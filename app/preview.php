

<?php
/// eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiZDBhM2M5OTgyZjc3NGE4OWZmOWJjMmMxODM2OTU4YzM2MTUxYjM5NGRjNmQ1NzcxNDQ0ZTFjMWMyMDAyNjkxNjU2YTRmY2RiMDcwYjliYWEiLCJpYXQiOjE3NTc0NTAxMTMuNjM0NzU5LCJuYmYiOjE3NTc0NTAxMTMuNjM0NzYsImV4cCI6NDkxMzEyMzcxMy42Mjk2NDIsInN1YiI6IjcyODcwNDI4Iiwic2NvcGVzIjpbInVzZXIucmVhZCIsInVzZXIud3JpdGUiLCJ0YXNrLnJlYWQiLCJ0YXNrLndyaXRlIiwid2ViaG9vay5yZWFkIiwid2ViaG9vay53cml0ZSIsInByZXNldC5yZWFkIiwicHJlc2V0LndyaXRlIl19.PWnGJ49CXKYLJRwqgJgUiaX9P0BWiH0P-iamx2Q5hkl4AcxNQdKY1HWkzJpLeSCy1QtKLMjpDTb-LNXhODKBb8FlNKz-K0I0L4I6O8OOrmzbfqDWeUruT9tLFZcVhNb6d0oVYOWYBV32OmQzkkMdxTpX2APnj26xCh5DURBB93G3MJKZc5wP0ASqxD0jKRgOMf-5HffGOp1oc6QSCexSJSdjM7OjUJdelxqj5T6qiZjt3g92kEUWTm60Jn5cioMVbjjjjM7hMovMV6JffkYJRO37QGQ0WQsTr1PFavvFOlbWm6B9UOwdiEsrhKODC8PF1DoSYRtOEO9ZmLMh_ao04AH78igk-o5vFzlj3CUfYN_0vsq7FdoofSZzsGeNTBRNfM3aBwbgA3Rp7SwowBSijV3qvt7SPuooCjyt3PNT1-pfRoWM4oJ_8TFtlibpSWwogtkVXjZWSa2lQiGEYGc0MPFfXM3eX0cKMG0yomhtVbpyptqghn6ZGazXwojW42_s94iUDnwJ3G8eh2tQ8arYe0FozYo6sWj9cii-Yjw769zilNnDHS8mJtrDzmO9ajC9bEe-D4JWWhVw7DUZyd0iCK-t2tWMQfwIkIRGCZSWCUXMO0P8P3UsHwFkfcykHOsYevzsCm-Ea_3l9X9aX29aStsOT7Pm0dzlv3ChfeccRFQ
$apiKey = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiZDBhM2M5OTgyZjc3NGE4OWZmOWJjMmMxODM2OTU4YzM2MTUxYjM5NGRjNmQ1NzcxNDQ0ZTFjMWMyMDAyNjkxNjU2YTRmY2RiMDcwYjliYWEiLCJpYXQiOjE3NTc0NTAxMTMuNjM0NzU5LCJuYmYiOjE3NTc0NTAxMTMuNjM0NzYsImV4cCI6NDkxMzEyMzcxMy42Mjk2NDIsInN1YiI6IjcyODcwNDI4Iiwic2NvcGVzIjpbInVzZXIucmVhZCIsInVzZXIud3JpdGUiLCJ0YXNrLnJlYWQiLCJ0YXNrLndyaXRlIiwid2ViaG9vay5yZWFkIiwid2ViaG9vay53cml0ZSIsInByZXNldC5yZWFkIiwicHJlc2V0LndyaXRlIl19.PWnGJ49CXKYLJRwqgJgUiaX9P0BWiH0P-iamx2Q5hkl4AcxNQdKY1HWkzJpLeSCy1QtKLMjpDTb-LNXhODKBb8FlNKz-K0I0L4I6O8OOrmzbfqDWeUruT9tLFZcVhNb6d0oVYOWYBV32OmQzkkMdxTpX2APnj26xCh5DURBB93G3MJKZc5wP0ASqxD0jKRgOMf-5HffGOp1oc6QSCexSJSdjM7OjUJdelxqj5T6qiZjt3g92kEUWTm60Jn5cioMVbjjjjM7hMovMV6JffkYJRO37QGQ0WQsTr1PFavvFOlbWm6B9UOwdiEsrhKODC8PF1DoSYRtOEO9ZmLMh_ao04AH78igk-o5vFzlj3CUfYN_0vsq7FdoofSZzsGeNTBRNfM3aBwbgA3Rp7SwowBSijV3qvt7SPuooCjyt3PNT1-pfRoWM4oJ_8TFtlibpSWwogtkVXjZWSa2lQiGEYGc0MPFfXM3eX0cKMG0yomhtVbpyptqghn6ZGazXwojW42_s94iUDnwJ3G8eh2tQ8arYe0FozYo6sWj9cii-Yjw769zilNnDHS8mJtrDzmO9ajC9bEe-D4JWWhVw7DUZyd0iCK-t2tWMQfwIkIRGCZSWCUXMO0P8P3UsHwFkfcykHOsYevzsCm-Ea_3l9X9aX29aStsOT7Pm0dzlv3ChfeccRFQ';

require '../error_log.php';
require '../vendor/autoload.php';
use CloudConvert\CloudConvert;
use CloudConvert\Models\Job;
use CloudConvert\Models\Task;

// Tu API Key de CloudConvert

$cloudconvert = new CloudConvert(['api_key' => $apiKey]);

// Carpetas locales
$originalDir = '../videos/online/';
$previewDir = '../online/';
if (!is_dir($originalDir)) mkdir($originalDir, 0777, true);
if (!is_dir($previewDir)) mkdir($previewDir, 0777, true);

// Verificar que se subió un video
if (!isset($_FILES['videoFile']) || $_FILES['videoFile']['error'] !== UPLOAD_ERR_OK) {
    die("Error: No se subió ningún archivo.");
}

$tmpPath = $_FILES['videoFile']['tmp_name'];
$originalName = basename($_FILES['videoFile']['name']);
$ext = pathinfo($originalName, PATHINFO_EXTENSION);

// Guardar copia local del video original
$targetPath = $originalDir . $originalName;
move_uploaded_file($tmpPath, $targetPath);

// Configurar directorio temporal personalizado
$tempDir = __DIR__ . '/../temp/';
if (!is_dir($tempDir)) {
    mkdir($tempDir, 0777, true);
}
ini_set('sys_temp_dir', $tempDir);
putenv('TMPDIR=' . $tempDir);

try {
    echo "🚀 Iniciando proceso de conversión...<br>";
    
    // 1️⃣ Crear el Job con las tareas
    $job = (new Job())
        ->addTask(
            new Task('import/upload', 'import-my-video')
        )
        ->addTask(
            (new Task('convert', 'convert-my-video'))
                ->set('input', 'import-my-video')
                ->set('output_format', 'mp4')
                ->set('audio_codec', 'aac')
                ->set('start', 2)
                ->set('duration', 15)
        )
        ->addTask(
            (new Task('export/url', 'export-my-video'))
                ->set('input', 'convert-my-video')
        );

    // 2️⃣ Crear el job en CloudConvert
    $job = $cloudconvert->jobs()->create($job);
    $jobId = $job->getId();
    echo "📋 Job creado con ID: $jobId<br>";

    // 3️⃣ Subir el archivo
    $importTask = $job->getTasks()->whereName('import-my-video')[0];
    echo "📤 Subiendo archivo: $originalName (" . round(filesize($targetPath) / 1024 / 1024, 2) . " MB)<br>";
    
    $fileResource = fopen($targetPath, 'r');
    if (!$fileResource) {
        throw new Exception("No se pudo abrir el archivo: $targetPath");
    }
    
    $cloudconvert->tasks()->upload($importTask, $fileResource, $originalName);
    // No cerrar el recurso manualmente - CloudConvert lo maneja
    
    echo "✅ Archivo subido correctamente<br>";

    // 4️⃣ Monitorear el progreso del job
    echo "⏳ Procesando video (esto puede tomar varios minutos)...<br>";
    
    try {
        // Intentar usar wait() con el objeto Job completo
        $job = $cloudconvert->jobs()->wait($job);
        echo "✅ Procesamiento completado<br>";
        
    } catch (Exception $waitException) {
        echo "⚠️ Método wait() falló, usando consulta manual: " . $waitException->getMessage() . "<br>";
        
        // Método alternativo: consultar periódicamente usando find()
        $maxAttempts = 60; // 5 minutos máximo
        $attempts = 0;
        
        do {
            sleep(5);
            $attempts++;
            
            try {
                // Usar find() que es más estable
                $jobs = $cloudconvert->jobs()->all(['filter' => ['id' => $jobId]]);
                if (!empty($jobs)) {
                    $job = $jobs[0];
                    $status = $job->getStatus();
                    echo "🔄 Estado: $status (Intento $attempts/$maxAttempts)<br>";
                    flush();
                    
                    if (in_array($status, ['finished', 'error'])) {
                        break;
                    }
                }
            } catch (Exception $e) {
                echo "⚠️ Error consultando job: " . $e->getMessage() . "<br>";
            }
            
        } while ($attempts < $maxAttempts);
    }

    // 5️⃣ Procesar resultado
    $finalStatus = $job->getStatus();
    echo "📊 Estado final del job: $finalStatus<br>";
    
    if ($finalStatus === 'finished') {
        echo "🎉 ¡Conversión exitosa!<br>";
        
        // Obtener la tarea de export
        $exportTask = null;
        foreach ($job->getTasks() as $task) {
            if ($task->getName() === 'export-my-video') {
                $exportTask = $task;
                break;
            }
        }
        
        if ($exportTask && $exportTask->getResult() && !empty($exportTask->getResult()->files)) {
            $downloadUrl = $exportTask->getResult()->files[0]->url;
            echo "🔗 Descargando preview desde CloudConvert...<br>";
            
            // Descargar el archivo
            $previewName = pathinfo($originalName, PATHINFO_FILENAME) . "_preview.mp4";
            $previewPath = $previewDir . $previewName;
            
            $ch = curl_init($downloadUrl);
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_TIMEOUT => 300
            ]);
            
            $previewContent = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $downloadSize = curl_getinfo($ch, CURLINFO_SIZE_DOWNLOAD);
            curl_close($ch);
            
            if ($httpCode === 200 && $previewContent && $downloadSize > 0) {
                if (file_put_contents($previewPath, $previewContent)) {
                    echo "✅ <strong>¡ÉXITO TOTAL!</strong><br>";
                    echo "📁 Original: $targetPath<br>";
                    echo "🎬 <a href='../online/$previewName' target='_blank' style='color: green; font-weight: bold;'>📥 DESCARGAR PREVIEW (15 segundos)</a><br>";
                    echo "📏 Tamaño: " . number_format($downloadSize / 1024, 2) . " KB<br>";
                } else {
                    echo "❌ Error guardando preview en servidor<br>";
                }
            } else {
                echo "❌ Error descargando preview (HTTP: $httpCode, Tamaño: $downloadSize)<br>";
            }
        } else {
            echo "❌ No se encontró archivo de salida en el resultado<br>";
        }
        
    } elseif ($finalStatus === 'error') {
        echo "❌ El job falló durante el procesamiento<br>";
        foreach ($job->getTasks() as $task) {
            if ($task->getStatus() === 'error') {
                echo "❌ Tarea '" . $task->getName() . "' falló<br>";
            }
        }
    } else {
        echo "⏰ Job no completado - Estado: $finalStatus<br>";
        echo "Job ID para revisión: $jobId<br>";
    }

} catch (Exception $e) {
    echo "❌ <strong>Error crítico:</strong> " . $e->getMessage() . "<br>";
    error_log("CloudConvert Error: " . $e->getMessage());
    
    if (isset($jobId)) {
        echo "Job ID: $jobId<br>";
    }
}

// Limpiar archivos temporales
if (isset($tempDir) && is_dir($tempDir)) {
    $tempFiles = glob($tempDir . '*');
    foreach ($tempFiles as $file) {
        if (is_file($file)) {
            @unlink($file);
        }
    }
}
?>