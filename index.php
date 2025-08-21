<?php
session_start();
include './db.php';
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
  <link
    href="https://fonts.googleapis.com/css2?family=Oswald:wght@500;700&family=Rubik:wght@400;500;700&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="./assets/css/style.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
  <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
  <?php include 'head.php'; ?>
  <style>
    
    .vosj{
      width: 101%;
      height: auto; 
    }
    @media (min-width: 767px){
     .vosj{
      height: 101%;
      width: auto; 
    }
    }
  </style>
</head>

<body id="top">
  <div class="preloader" data-preloader>
    <div class="circle"></div>
  </div>

  <?php include 'ofer.php'; ?>

  <?php include 'header.php'; ?>

  <main style="overflow: hidden;">
    <article>
      <section class="hero-banner" style="position: relative">
      <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: -1; display: flex; justify-content: center; align-items: center;">
          <video autoplay loop muted playsinline style="position: absolute; top: 50%; left: 50%; width: 100%; height: 100%; object-fit: cover; transform: translate(-50%, -50%);z-index: 2"
          poster="./assets/img/hero@3x.png">
            <source src="./assets/images/banner-hero3.mp4" type="video/mp4">
            Your browser does not support the video tag.
          </video>
        </div>
        <div class="bg-b"></div>
        <div class="container">
          <div class="hero-banner-elements">
            <div class="img-banner-container">
              <svg class="hero-log" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 53.4 88.89"><defs></defs><g id="Capa_2" data-name="Capa 2"><g id="Capa_1-2" data-name="Capa 1"><path class="cls-log" d="M32.21,24.19a5.91,5.91,0,1,1-5.91-5.91,5.9,5.9,0,0,1,5.91,5.91"/><path class="cls-log" d="M26.71,88.89A6,6,0,0,1,23.6,88a5.78,5.78,0,0,1-.68-.49c-1.87-1.6-3-5.08-3.56-10.63a69.28,69.28,0,0,1-.26-7.45c.42-14.51,1.58-18.07,2.82-20.7a34.35,34.35,0,0,1,2.91-5,40.32,40.32,0,0,0-5.3-5.43,76.74,76.74,0,0,1-6.07-6,60.26,60.26,0,0,1-4.27-5.16A48.14,48.14,0,0,1,0,.12L3,0a45.21,45.21,0,0,0,8.6,25.49,60.58,60.58,0,0,0,4.05,4.9l.4.44c2.15,2.33,3.92,3.91,5.48,5.32a44.6,44.6,0,0,1,5.17,5.2,44.55,44.55,0,0,1,5.16-5.2,75.16,75.16,0,0,0,5.48-5.32h0l.41-.43a59.23,59.23,0,0,0,4-4.9A45.22,45.22,0,0,0,50.4,0l3,.12a48.14,48.14,0,0,1-9.19,27.15,62.73,62.73,0,0,1-4.27,5.16,76.74,76.74,0,0,1-6.07,6,39.73,39.73,0,0,0-5.3,5.43,34.44,34.44,0,0,1,2.9,5c1.25,2.63,2.4,6.19,2.83,20.7A67.82,67.82,0,0,1,34,76.92c-.52,5.55-1.69,9-3.56,10.63a5,5,0,0,1-.67.49,5.94,5.94,0,0,1-3.09.85m0-42.49a31.22,31.22,0,0,0-2.07,3.66c-1.06,2.23-2.13,5.58-2.53,19.5-.15,5,.47,13.74,2.77,15.7a2.68,2.68,0,0,0,.3.23,3,3,0,0,0,1.54.4,3,3,0,0,0,1.51-.4,1.6,1.6,0,0,0,.3-.23c1.23-1,3.06-6.22,2.78-15.7-.41-13.92-1.48-17.27-2.54-19.5A31.3,31.3,0,0,0,26.7,46.4"/></g></g></svg>
            </div>
            <h1>
             Movement as an act <br> of authenticity
            </h1>
            <a href="reserva.php" class="reservar-btn-banner">« RESERVAR »</a>
          </div>
        </div>
      </section>
      <section class="section" style="background: rgb(242, 231, 219);">
        <div class="container">
          <div class="explora-section">
              <svg class="loto-explora" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 92.78 56.13"><defs></defs><g id="Capa_2" data-name="Capa 2"><g id="Capa_1-2" data-name="Capa 1"><path class="cls-loto-explora" d="M91.87,42.22a31.52,31.52,0,0,0-19.36-8.55,31.6,31.6,0,0,0,5.08-20.56l-.12-1.25H76.21a31.57,31.57,0,0,0-20,7.37A31.5,31.5,0,0,0,45.48.81L44.53,0l-.89.88a31.2,31.2,0,0,0-8.9,16.92,31.76,31.76,0,0,0-18.17-5.92l-1.25,0-.13,1.25a31.55,31.55,0,0,0,5.08,20.55A31.59,31.59,0,0,0,.91,42.22L0,43.08l.77,1A31.4,31.4,0,0,0,22,55.92a30.61,30.61,0,0,0,3.59.21,31.51,31.51,0,0,0,20.76-7.81,31.52,31.52,0,0,0,20.77,7.81,33.18,33.18,0,0,0,3.58-.2A31.41,31.41,0,0,0,92,44.07l.77-1Zm-21.44,11a29,29,0,0,1-20.56-5.6A31.33,31.33,0,0,0,70.49,36.4l.07-.09a28.77,28.77,0,0,1,18.49,7,28.74,28.74,0,0,1-18.62,9.85Zm-48.08,0h0A28.64,28.64,0,0,1,3.74,43.35a28.76,28.76,0,0,1,18.48-7l.07.09a31.73,31.73,0,0,0,7,6.28,31.46,31.46,0,0,0,13.61,4.93A28.9,28.9,0,0,1,22.35,53.2Zm15.12-16A31.12,31.12,0,0,0,26.2,33.77c-.83-.1-1.7-.16-2.63-.18a28.76,28.76,0,0,1-5.75-18.93A28.92,28.92,0,0,1,34.35,21c-.07.84-.1,1.63-.1,2.4A31.6,31.6,0,0,0,37.47,37.25Zm1.07-12.18A28.61,28.61,0,0,1,45,40.39c-.07.77-.11,1.55-.13,2.34-.58-.58-1.18-1.14-1.79-1.66A29,29,0,0,1,37,23.35C37.55,23.92,38.06,24.49,38.54,25.07ZM30.8,40.39h0a28.69,28.69,0,0,1-4.7-3.87,28.63,28.63,0,0,1,15,6.49c.5.63,1,1.24,1.55,1.82A28.86,28.86,0,0,1,30.8,40.39Zm6.43-20.6a28.32,28.32,0,0,1,7.45-16,28.78,28.78,0,0,1,9.11,17.74c-.63.63-1.17,1.24-1.66,1.83a31.22,31.22,0,0,0-5.74,10.43,31.22,31.22,0,0,0-5.74-10.43A32.54,32.54,0,0,0,37.23,19.79Zm19.4,2.72A28.76,28.76,0,0,1,75,14.65a28.79,28.79,0,0,1-5.75,18.94c-.93,0-1.8.09-2.63.18a31.57,31.57,0,0,0-12.66,4.28A31.67,31.67,0,0,0,56.74,25C56.74,24.21,56.7,23.4,56.63,22.51Zm10,14A27.92,27.92,0,0,1,62,40.4a28.76,28.76,0,0,1-12.28,4.48l.19-.24A28.51,28.51,0,0,1,66.67,36.52ZM54,25.37a28.51,28.51,0,0,1-6.1,17.34c0-.78-.06-1.55-.13-2.3A28.67,28.67,0,0,1,54,25.37Z"/><path class="cls-loto-explora" d="M45.84,24.56a5.13,5.13,0,1,0-5.12-5.12A5.13,5.13,0,0,0,45.84,24.56Zm0-7.51a2.39,2.39,0,1,1-2.38,2.39A2.39,2.39,0,0,1,45.84,17.05Z"/></g></g></svg>
              <h3>
                Explora tu <b style="color: var(--c7);  font-weight: 500;">autenticidad</b> a <br>
                través del cuerpo y <br>
                la mente
              </h3>
              <a href="#">« ABOUT US »</a>
          </div>
        </div>
      </section>

      

      <section class="section desciplinas-section">
       <div class="container">
          <h2>Nuestras Disciplinas</h2>

            <div class="slider-container-global disciplines-slider" style="margin-top: 0;">
              <div class="swiper-button-prev flecha-slider fi"></div>
              
              <div class="swiper-container">
                <div class="swiper-wrapper">

                <?php
                    $sqlDI = ("SELECT id, nombre_disciplina, descripcion_disciplina, subdescripcion_texto1, subdescripcion_texto2, subdescripcion_texto3 FROM disciplinas");
                    $stmtDI = $conn->prepare($sqlDI);
                    $stmtDI->execute();
                    $resultDI = $stmtDI->get_result();

                    while($rowDI = $resultDI->fetch_assoc()){

                      $imgDI = './assets/images/disciplinas/' . $rowDI['id'] . '.png';
                      if(!file_exists($imgDI)){
                        $imgDI = "./assets/images/disciplinas/unknow.jpg";
                      }

                      echo '<div class="swiper-slide">
                              <div class="card-disciplina">
                                <h4>' . $rowDI['nombre_disciplina'] . '</h4>
                                <div class="card-disciplina-img">
                                  <img src="' . $imgDI . '" alt="SATYA ' . $rowDI['nombre_disciplina'] . '">
                                </div>
                                <span>' . $rowDI['subdescripcion_texto1'] . ' - ' . $rowDI['subdescripcion_texto2'] . ' - ' . $rowDI['subdescripcion_texto1'] . '</span>
                              </div>
                            </div>';
                    }
                ?>
                 
                  
                  <!-- Añade más disciplinas según necesites -->
                </div>
              </div>
              
              <div class="swiper-button-next flecha-slider fd"></div>
            </div>


          <a href="#" class="a-link" style="margin-top: 20px;">« VER MÁS »</a>
       </div>
      </section>

      <section class="section coaches-section">
        <div class="container">
          <h2>Conoce a tu Coach</h2>
          <div class="slider-container-global coaches-slider">
            <div class="swiper-button-prev flecha-slider fi"></div>
            
            <div class="swiper-container">
              <div class="swiper-wrapper">
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
                    if (!file_exists($defaultPath)) {
                        $imgC = '<img src="./assets/images/coaches/unknow.jpg" alt="">';
                    }

                }else{
                    $imgC = '<video autoplay loop muted playsinline style="width: 100%; height: 100%; object-fit: cover;"
                                poster="./assets/images/coaches/unknow.jpg">
                                <source src="' . $coachPath . '" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>';
                }

                echo '
                    <div class="swiper-slide">
                      <div class="card-coach-index">
                      ' . $imgC . '
                      <div class="descrip-coach-index">
                        <h3>'. $disciplina .'</h3>
                        <p>'. $fila['descripcion_coach'] .'</p>
                      </div>
                      <a href="coaches.php?#'. $fila['nombre_coach'] .'">'. $fila['nombre_coach'] .'</a>
                    </div>
                  </div>
                ';
            }

            
        ?>
                
                
                <!-- Agrega más cards según necesites -->
              </div>
            </div>
            
            <div class="swiper-button-next flecha-slider fd"></div>
          </div>
          <a href="#" class="a-link">« VER MÁS »</a>
        </div>
      </section>

      <section class="section membresias-section">
        <div class="container">
          <h2>Nuestros Paquetes</h2>
            <!--slider paquetes-->
            <div class="slider-container-global packages-slider">
              <div class="swiper-button-prev flecha-slider fi"></div>
              
              <div class="swiper-container">
                <div class="swiper-wrapper">
                  <?php
                    $sqlPI = ("SELECT id, clases, costo, nombre, vigencia FROM paquetes ORDER BY RAND()");
                    $stmtPI = $conn->prepare($sqlPI);
                    $stmtPI->execute();
                    $resultPI = $stmtPI->get_result();

                    while($rowPI = $resultPI->fetch_assoc()){
                       if($rowPI['nombre'] == "Movement"){
                        $colorActual = "var(--c6)";

                        }else if($rowPI['nombre'] == "Mixto"){
                          $colorActual = "var(--c8)";
                        }else{
                          $colorActual = "var(--c2)";
                        }
                      echo '
                      <div class="swiper-slide">
                        <div class="card">
                          <p class="numero-clases-card" style="color: ' . $colorActual . ';">' . $rowPI['clases'] . '</p>
                          <p class="clases-card" style="color: ' . $colorActual . ';">Clases</p>
                          <p class="clases-card" style="font-size: 2rem;">' . $rowPI['nombre'] . '</p>
                          <p class="vigencia-card" style="margin-top: 0">Vigencia ' . $rowPI['vigencia'] . ' días</p>
                          
                          <div class="coust" style="background: ' . $colorActual . '">
                            <p class="precio-card">$' . $rowPI['costo'] . '<small>MX</small></p>
                            <a href="checkout.php?tkn=4VKZkLL1nkJ8ulKru0nymfKW8IX34TDS2vtF72RT9o5HwkbMvI8xF3do1XndhUoZepPQNfAvIsTwEtto3h7IzRFwxDXmF3evJOeCLUaWVhPOBh7bRxcoeN10SJjlWGCzxIVy&id=' . $rowPI['id'] . '">Comprar</a>
                          </div>
                        </div>
                      </div>
                      ';

                    }
                    $conn->close();
                ?>
                 
                 
                </div>
              </div>
              
              <div class="swiper-button-next flecha-slider fd" style="color: var(--c2)"></div>
            </div>

            <!-- slider paquetes--> 
                    <a href="paquetes.php" class="a-link" style="margin-top: 20px;">« VER TODOS »</a>
        </div>
      </section>

      <section class="section preguntas-section">
        <div class="container">
          

          <div class="preguntas-container">
            <h2>Preguntas Frecuentes</h2>
            <div class="preguntas-division"></div>
            <button class="accordion">
              <p>¿Puedo hacer ejercicio si tengo alguna lesión?</p>
            </button>
            <div class="panel">
              <p>Sí. Es importante que nos informes con anticipación. Nuestras instructoras están capacitadas para adaptar los ejercicios según tus necesidades. Siempre consulta previamente con tu médico antes de iniciar cualquier actividad física.</p>
            </div>

            <button class="accordion">
              <p>¿Puedo practicar estas disciplinas si estoy embarazada o en etapa de posparto?</p>
            </button>
            <div class="panel">
              <p>Sí, ofrecemos clases adaptadas para mujeres embarazadas o en proceso de recuperación postparto, siempre con autorización médica. Es importante contar con autorización médica antes de comenzar.</p>
            </div>

            

            <button class="accordion">
              <p>¿Necesito experiencia previa para empezar?</p>
            </button>
            <div class="panel">
              <p>No. Nuestras clases están diseñadas para todos los niveles. Las instructoras te guiarán y ajustarán los movimientos según tus capacidades. No necesitas experiencia previa para comenzar.</p>
            </div>
            <button class="accordion">
              <p>¿Qué debo llevar a clase?</p>
            </button>
            <div class="panel">
              <p> Ropa cómoda que te permita moverte con libertad. Recomendamos el uso de calcetines antideslizantes para mayor seguridad.</p>
            </div>
            <button class="accordion">
              <p>¿Cuántas veces a la semana debería tomar clases?</p>
            </button>
            <div class="panel">
              <p>Para obtener resultados visibles y sentir los beneficios físicos y mentales, recomendamos practicar al menos 2 veces por semana.</p>
            </div>
            <button class="accordion">
              <p>¿Cuánto duran las clases?</p>
            </button>
            <div class="panel">
              <p>La mayoría de nuestras clases tienen una duración de entre 50 y 60 minutos.</p>
            </div>
            <button class="accordion">
              <p>¿Se requiere reservar o puedo llegar directamente?</p>
            </button>
            <div class="panel">
              <p>Es necesario reservar tu lugar con anticipación, ya que los espacios son limitados para garantizar una atención personalizada.</p>
            </div>
            <button class="accordion">
              <p>¿Puedo cancelar o reprogramar una clase?</p>
            </button>
            <div class="panel">
              <p>Sí. Aceptamos cancelaciones con al menos 6 horas de anticipación (ajustable según política). De lo contrario, la clase se considerará como tomada.</p>
            </div>
            <button class="accordion">
              <p>¿Cuál es la edad mínima para asistir a clases?</p>
            </button>
            <div class="panel">
              <p>A partir de los 13 años, con autorización de un adulto o tutor.</p>
            </div>
            <button class="accordion">
              <p>¿Cómo reservo una clase?</p>
            </button>
            <div class="panel">
              <p>Puedes reservar a través de nuestra página web, app, o directamente por WhatsApp o teléfono.</p>
            </div>
            <button class="accordion">
              <p>¿Cuáles son los métodos de pago aceptados?</p>
            </button>
            <div class="panel">
              <p>Aceptamos tarjeta de crédito/débito, pagos en efectivo y transferencias bancarias.</p>
            </div>
            <button class="accordion">
              <p>¿Qué tipo de clases ofrece SATYA?</p>
            </button>
            <div class="panel">
              <p>Todas nuestras clases son de bajo impacto y están diseñadas para fortalecer cuerpo y mente. Ofrecemos: <br>
                • Pilates Mat <br>
                • Barre <br>
                • Sculpt <br>
                • Yoga <br>
                Puedes consultar la descripción de cada clase para saber cuál se adapta mejor a tus objetivos.
              </p>
            </div>
            <a class="ayuda-btn" href="contacto.php">AYUDA</a>
          </div>
          
        </div>
      </section>

    </article>
  </main>
  <?php include 'footer.php'; ?>

  <script src="./assets/js/script.js?v=<?php echo time(); ?>"></script>
  <script type="module"
    src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule
    src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
  <?php include 'script.php'; ?>
  <script>
    cambiarTextoVideo(pilatesTab);
  </script>
</body>

</html>