<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SATYA Studio</title>
    <meta name="title" content="SATYA Studio">
    <meta name="description" content="SATYA es un espacio dedicado al bienestar y la conexión entre cuerpo y mente, creado por dos hermanas que comparten la pasión por el movimiento y el cuidado integral.">
    <link rel="shortcut icon" href="./favicon.png" type="image/svg+xml">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@500;700&family=Rubik:wght@400;500;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/style.css?v=<?php echo time(); ?>">
    <?php include 'head.php'; ?>
</head>

<body id="top">
    <div class="preloader" data-preloader>
        <div class="circle"></div>
    </div>
  

    <?php include 'ofer.php'; ?>

    <?php include 'header.php'; ?>

    <main>
        <article>
            <section class="section">
                <div class="container">

            <?php 
            include 'db.php';

            ini_set('display_errors', 1);
            error_reporting(E_ALL);

            $idDisciplinas = [];

            $query = "SELECT id, nombre_coach, descripcion_coach, id_disciplina FROM coaches";
            $query2 = "SELECT id, nombre_disciplina FROM disciplinas";

            $resultado = $conn->query($query);
            $resultado2 = $conn->query($query2);

            if (!$resultado || !$resultado2) {
                die("Error en la consulta: " . $conn->error);
            }

            $intercalador = 1;

            while ($fila2 = mysqli_fetch_assoc($resultado2)) {
                $idDisciplinas[$fila2['id']] = $fila2['nombre_disciplina'];
            }

            while ($fila = mysqli_fetch_assoc($resultado)) {
                // Validación de disciplina
                $disciplina = isset($idDisciplinas[$fila['id_disciplina']]) 
                                ? $idDisciplinas[$fila['id_disciplina']] 
                                : 'SATYA';
                $coachPath = "./assets/images/coaches/" . $fila['id'] . ".mp4";
                $defaultPath = "./assets/images/coaches/" . $fila['id'] . ".png";
        
                if (!file_exists($coachPath)) {
                    $imgC = '<img src="'. $defaultPath .'" alt="">';

                }else{
                    $imgC = '<video autoplay loop muted playsinline style="width: 100%; height: 100%; object-fit: cover;"
                                poster="./assets/images/coaches/unknow.jpg">
                                <source src="' . $coachPath . '" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>';
                }

                echo '
                
                    <div class="card-coach-index">
                    ' . $imgC . '
                    <div class="descrip-coach-index">
                      <h3>'. $disciplina .'</h3>
                      <p>'. $fila['descripcion_coach'] .'</p>
                    </div>
                    <a href="#">'. $fila['nombre_coach'] .'</a>
                  </div>
                ';
            }

            $conn->close();
        ?>

                </div>
            </section>
        </article>
    </main> 

    
    <?php include 'footer.php'; ?>
  
    <script src="./assets/js/script.js?v=<?php echo time(); ?>"></script> 
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <?php include 'script.php'; ?>
</body>

</html>