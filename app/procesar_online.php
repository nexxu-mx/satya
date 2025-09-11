<?php
        // Carpeta donde guardar videos originales y previews
        $originalDir = '../videos/online/';
        $previewDir = '../online/';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type = $_POST['type'];
    $level = $_POST['level'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $equipment = $_POST['equipment'];

    $video = $_FILES['videoFile'] ?? null;
    $miniatura = $_FILES['miniatureFile'] ?? null;


    /// Logica para manejar el video
  


        // Crear carpetas si no existen
        if (!is_dir($originalDir)) mkdir($originalDir, 0777, true);
        if (!is_dir($previewDir)) mkdir($previewDir, 0777, true);

        // Video subido
        if (isset($_FILES['videoFile']) && $_FILES['videoFile']['error'] === UPLOAD_ERR_OK) {
            $tmpPath = $_FILES['videoFile']['tmp_name'];
            $originalName = basename($_FILES['videoFile']['name']);
            $ext = pathinfo($originalName, PATHINFO_EXTENSION);

            // Guardar video original
            $targetPath = $originalDir . $originalName;
            move_uploaded_file($tmpPath, $targetPath);

            // Obtener duración del video usando ffprobe
            $cmdDuration = "ffprobe -v error -show_entries format=duration -of csv=p=0 " . escapeshellarg($targetPath);
            $dura = floatval(shell_exec($cmdDuration)); // duración en segundos

            // Crear preview de 15 segundos desde el segundo 20
            $previewName = pathinfo($originalName, PATHINFO_FILENAME) . "_preview." . $ext;
            $previewPath = $previewDir . $previewName;

            // Comando FFmpeg seguro
            $cmdPreview = "ffmpeg -y -i " . escapeshellarg($targetPath) . " -ss 20 -t 15 -c:v libx264 -c:a aac -movflags +faststart " . escapeshellarg($previewPath);

            // Ejecutar y capturar salida para depuración
            exec($cmdPreview . " 2>&1", $output, $return_var);

            if ($return_var !== 0) {
                echo "Error creando preview:<br>";
                echo implode("<br>", $output);
            } else {
                 echo "Preview guardado en: $previewPath<br>";
            }
            ///Logica para almacenar la miniatura

            echo "$title/$description / $type / $level / $equipment -- '$dura' ($targetPath)($previewPath)<br>";
        }
    

}
?>