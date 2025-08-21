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
    <div class="bg-opacity-modals"></div>
    <div class="preloader" data-preloader>
        <div class="circle"></div>
    </div>

    <?php include 'ofer.php'; ?>
    <?php include 'header.php'; ?>


    <main>
        <article>
            <section class="reserva-main-section" id="reserv" style="background: var(--background);">
          
                <div class="container">
            <!--        <img src="assets/images/svg/logo-blanco.svg" alt="Logo SATYA"> 
            -->
                    <h1 style="color: var(--c9); margin-top: 60px" id="nyclass">Book your class</h1>
                    <p class="conf-rese" id="dis-res"></p>
                    <div class="lotoreserva"><img src="./assets/img/icono_loto.svg"  alt=""></div>
                    
                    <div class="confirmation-section"  id="confirm-class">
                        <div class="class-confirm-fecha">
                                <div class="cc-horario">
                                    <h3 id="confirm-horario"></h3>
                                </div>
                                <div class="cc-fecha">
                                         <div class="fecha-clase-container elemento-clase" style="margin-bottom: 0">
                                                <p> <span id="numero-dia-din-conf" class="texto-fecha-din">27</span> De <span id="mes-din-conf" class="texto-fecha-din">Marzo</span></p>
                                        </div>
                                </div>
                        </div>
                        <div class="select-mat" id="infmat">

                            <div class="info-mat" >
                                    <div class="mat-reser">
                                        <svg  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 53.4 88.89"><defs></defs><g id="Capa_2" data-name="Capa 2"><g id="Capa_1-2" data-name="Capa 1"><path class="cls-reser" d="M32.21,24.19a5.91,5.91,0,1,1-5.91-5.91,5.9,5.9,0,0,1,5.91,5.91"/><path class="cls-reser" d="M26.71,88.89A6,6,0,0,1,23.6,88a5.78,5.78,0,0,1-.68-.49c-1.87-1.6-3-5.08-3.56-10.63a69.28,69.28,0,0,1-.26-7.45c.42-14.51,1.58-18.07,2.82-20.7a34.35,34.35,0,0,1,2.91-5,40.32,40.32,0,0,0-5.3-5.43,76.74,76.74,0,0,1-6.07-6,60.26,60.26,0,0,1-4.27-5.16A48.14,48.14,0,0,1,0,.12L3,0a45.21,45.21,0,0,0,8.6,25.49,60.58,60.58,0,0,0,4.05,4.9l.4.44c2.15,2.33,3.92,3.91,5.48,5.32a44.6,44.6,0,0,1,5.17,5.2,44.55,44.55,0,0,1,5.16-5.2,75.16,75.16,0,0,0,5.48-5.32h0l.41-.43a59.23,59.23,0,0,0,4-4.9A45.22,45.22,0,0,0,50.4,0l3,.12a48.14,48.14,0,0,1-9.19,27.15,62.73,62.73,0,0,1-4.27,5.16,76.74,76.74,0,0,1-6.07,6,39.73,39.73,0,0,0-5.3,5.43,34.44,34.44,0,0,1,2.9,5c1.25,2.63,2.4,6.19,2.83,20.7A67.82,67.82,0,0,1,34,76.92c-.52,5.55-1.69,9-3.56,10.63a5,5,0,0,1-.67.49,5.94,5.94,0,0,1-3.09.85m0-42.49a31.22,31.22,0,0,0-2.07,3.66c-1.06,2.23-2.13,5.58-2.53,19.5-.15,5,.47,13.74,2.77,15.7a2.68,2.68,0,0,0,.3.23,3,3,0,0,0,1.54.4,3,3,0,0,0,1.51-.4,1.6,1.6,0,0,0,.3-.23c1.23-1,3.06-6.22,2.78-15.7-.41-13.92-1.48-17.27-2.54-19.5A31.3,31.3,0,0,0,26.7,46.4"/></g></g></svg>
                                        <p>Reservado</p>
                                    </div>
                                    <div class="mat-dispo">
                                        <svg  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 53.4 88.89"><defs></defs><g id="Capa_2" data-name="Capa 2"><g id="Capa_1-2" data-name="Capa 1"><path class="cls-dispo" d="M32.21,24.19a5.91,5.91,0,1,1-5.91-5.91,5.9,5.9,0,0,1,5.91,5.91"/><path class="cls-dispo" d="M26.71,88.89A6,6,0,0,1,23.6,88a5.78,5.78,0,0,1-.68-.49c-1.87-1.6-3-5.08-3.56-10.63a69.28,69.28,0,0,1-.26-7.45c.42-14.51,1.58-18.07,2.82-20.7a34.35,34.35,0,0,1,2.91-5,40.32,40.32,0,0,0-5.3-5.43,76.74,76.74,0,0,1-6.07-6,60.26,60.26,0,0,1-4.27-5.16A48.14,48.14,0,0,1,0,.12L3,0a45.21,45.21,0,0,0,8.6,25.49,60.58,60.58,0,0,0,4.05,4.9l.4.44c2.15,2.33,3.92,3.91,5.48,5.32a44.6,44.6,0,0,1,5.17,5.2,44.55,44.55,0,0,1,5.16-5.2,75.16,75.16,0,0,0,5.48-5.32h0l.41-.43a59.23,59.23,0,0,0,4-4.9A45.22,45.22,0,0,0,50.4,0l3,.12a48.14,48.14,0,0,1-9.19,27.15,62.73,62.73,0,0,1-4.27,5.16,76.74,76.74,0,0,1-6.07,6,39.73,39.73,0,0,0-5.3,5.43,34.44,34.44,0,0,1,2.9,5c1.25,2.63,2.4,6.19,2.83,20.7A67.82,67.82,0,0,1,34,76.92c-.52,5.55-1.69,9-3.56,10.63a5,5,0,0,1-.67.49,5.94,5.94,0,0,1-3.09.85m0-42.49a31.22,31.22,0,0,0-2.07,3.66c-1.06,2.23-2.13,5.58-2.53,19.5-.15,5,.47,13.74,2.77,15.7a2.68,2.68,0,0,0,.3.23,3,3,0,0,0,1.54.4,3,3,0,0,0,1.51-.4,1.6,1.6,0,0,0,.3-.23c1.23-1,3.06-6.22,2.78-15.7-.41-13.92-1.48-17.27-2.54-19.5A31.3,31.3,0,0,0,26.7,46.4"/></g></g></svg>
                                        <p>Disponible</p>
                                    </div>
                            </div>

                          

                            <div id="esp" class="mat-pad"></div>


                             <div class="reformer" id="esp2"></div>

                        </div>
                        <div class="confirmation-btns">
                            <p class="cancelar-confirmacion-reserva-btn" onclick="cancelConfirmacion()">Cancelar</p>
                            <p class="confirmar-reserva-btn" id="confirm-agendar" onclick="confirmacion(this)">Confirmar Reserva</p>
                        </div>
                        <p class="nota-cancelar-clase"><span>Nota</span>: Puedes cancelar tu reservación, con hasta 10 horas de anticipación desde "Mis Reservas"</p>
                    </div>
                    <div class="white-container" >
                        <p class="my-account-link"><a href="login.php" id="my-account">«MI CUENTA»</a></p>
                        <div class="first-flex">
                            <div class="hint-flex">
                               <div style="margin-bottom: 50px;">
                                    <div class="inputs-container" style="margin-top: -20px;">
                                        <div class="buscar-input-container">
                                        <input type="text" placeholder="BUSCAR">
                                        <img src="assets/images/svg/search.svg" alt="search icon">
                                        </div>
                                        <select name="clases" id="slc-disciplina">
                                        <option value="" selected>Todos</option>
                                        <?php
                                            include './db.php';
                                            $sqlPB = ("SELECT id, nombre_disciplina FROM disciplinas");
                                            $stmtPB = $conn->prepare($sqlPB);
                                            $stmtPB->execute();
                                            $resultPB = $stmtPB->get_result();
                                            while($rowPB = $resultPB->fetch_assoc()){
                                                echo '
                                                <option value="' . $rowPB['id'] . '">' . $rowPB['nombre_disciplina'] . '</option>
                                                ';
                                            }

                                        ?>
                                        </select>
                                        
                                    </div>
                               </div>
                                <h2 id="tipoClase"></h2>
                                <svg id="hint-icon" xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512"><title>Help Circle</title><path d="M256 64C150 64 64 150 64 256s86 192 192 192 192-86 192-192S362 64 256 64zm-6 304a20 20 0 1120-20 20 20 0 01-20 20zm33.44-102C267.23 276.88 265 286.85 265 296a14 14 0 01-28 0c0-21.91 10.08-39.33 30.82-53.26C287.1 229.8 298 221.6 298 203.57c0-12.26-7-21.57-21.49-28.46-3.41-1.62-11-3.2-20.34-3.09-11.72.15-20.82 2.95-27.83 8.59C215.12 191.25 214 202.83 214 203a14 14 0 11-28-1.35c.11-2.43 1.8-24.32 24.77-42.8 11.91-9.58 27.06-14.56 45-14.78 12.7-.15 24.63 2 32.72 5.82C312.7 161.34 326 180.43 326 203.57c0 33.83-22.61 49.02-42.56 62.43z"/></svg>
                            </div>
                            <div class="inputs-reserva-container">
                               <!-- <select name="tipo_clase" id="tipo_clase_input">
                                    <option value="TIPO DE CLASE">TIPO DE CLASE</option>
                                </select>
                                <select name="instructor" id="instructor_input">
                                    <option value="INSTRUCTOR">INSTRUCTOR</option>
                                </select>
                                -->
                            </div>
                        </div>
                        <div class="second-flex">
                            <div class="icono-texto-reserva">
                                <img class="icono-reserva" src="assets/images/svg/reservado.svg"
                                    alt="Clase reservada ícono">
                                <p>Clase reservada</p>
                            </div>
                            <div class="icono-texto-reserva">
                                <img class="icono-reserva" src="assets/images/svg/full_class.svg"
                                    alt="Clase llena ícono">
                                <p>Clase llena</p>
                            </div>
                            <div class="icono-texto-reserva">
                                <img class="icono-reserva" src="assets/images/svg/waiting_list.svg"
                                    alt="Lista de Espera ícono">
                                <p>Lista de Espera</p>
                            </div>
                            <div class="icono-texto-reserva">
                                <img class="aforo-icono" src="assets/images/svg/people-sharp.svg" alt="Aforo ícono">
                                <p>Aforo</p>
                            </div>
                            <div class="icono-texto-reserva">
                                <svg xmlns="http://www.w3.org/2000/svg" class="ionicon clase-en-curso-punto"
                                    viewBox="0 0 512 512">
                                    <defs>
                                        <style>
                                            .ionicon {
                                                fill: #986C5D;
                                            }
                                        </style>
                                    </defs>
                                    <title>Ellipse</title>
                                    <path
                                        d="M256 464c-114.69 0-208-93.31-208-208S141.31 48 256 48s208 93.31 208 208-93.31 208-208 208z" />
                                </svg>
                                <p>Clase en curso</p>
                            </div>
                        </div>
                        <div class="slider-calendar-container">
                            <p class="flecha-slider-calendar">
                                < </p>

                                    <div class="slider-items-container" id="slider-container">
                                        <div class="bg-sd"></div>
                                        <div class="day-slider">
                                            <p class="text-day-slider"></p>
                                            <p class="calendar-slider-number"></p>
                                        </div>
                                        <div class="day-slider">
                                            <p class="text-day-slider"></p>
                                            <p class="calendar-slider-number"></p>
                                        </div>
                                        <div class="day-slider">
                                            <p class="text-day-slider"></p>
                                            <p class="calendar-slider-number"></p>
                                        </div>
                                        <div class="day-slider">
                                            <p class="text-day-slider"></p>
                                            <p class="calendar-slider-number"></p>
                                        </div>
                                        <div class="day-slider">
                                            <p class="text-day-slider"></p>
                                            <p class="calendar-slider-number"></p>
                                        </div>
                                        <div class="day-slider">
                                            <p class="text-day-slider"></p>
                                            <p class="calendar-slider-number"></p>
                                        </div>
                                        <div class="day-slider">
                                            <p class="text-day-slider"></p>
                                            <p class="calendar-slider-number"></p>
                                        </div>
                                        <div class="day-slider">
                                            <p class="text-day-slider"></p>
                                            <p class="calendar-slider-number"></p>
                                        </div>
                                        <div class="day-slider">
                                            <p class="text-day-slider"></p>
                                            <p class="calendar-slider-number"></p>
                                        </div>
                                        <div class="day-slider">
                                            <p class="text-day-slider"></p>
                                            <p class="calendar-slider-number"></p>
                                        </div>
                                        <div class="day-slider">
                                            <p class="text-day-slider"></p>
                                            <p class="calendar-slider-number"></p>
                                        </div>
                                        <div class="day-slider">
                                            <p class="text-day-slider"></p>
                                            <p class="calendar-slider-number"></p>
                                        </div>
                                        <div class="day-slider">
                                            <p class="text-day-slider"></p>
                                            <p class="calendar-slider-number"></p>
                                        </div>
                                        <div class="day-slider">
                                            <p class="text-day-slider"></p>
                                            <p class="calendar-slider-number"></p>
                                        </div>
                                        <div class="day-slider">
                                            <p class="text-day-slider"></p>
                                            <p class="calendar-slider-number"></p>
                                        </div>
                                    </div>

                                    <p class="flecha-slider-calendar">></p>
                        </div>
                        <div class="clases-section-container">
                            <div class="fecha-clase-container elemento-clase">
                                <p><span id="texto-dia-din" class="texto-fecha-din">Hoy</span>, <span id="mes-din" class="texto-fecha-din">Marzo</span> <span id="numero-dia-din" class="texto-fecha-din">27</span></p>
                            </div>
                           
                            
                            <div id="clazx" class="reservas-list"></div>

                        </div>
                       
                    </div>
                </div>
                </div>
            </section>
        </article>
    </main>

    <section class="modal-detalles-coach">
        <div class="header-details-container">
            <h2>About</h2>
            <p class="close-coach-modal-btn">X</p>
        </div>
        <div class="contenido-modal-coach-container">
            <img class="foto-coach-details-modal" src="" id="coach-info-img" alt="Foto Coach">
            <h3 class="nombre-coach-details-modal" id="coach-info-nombre"></h3>
            <p class="texto-coach-details-modal" id="coach-info-descripcion"></p>
        </div>
    </section>

    <section class="modal-detalles-disciplina">
        <div class="header-details-container">
            <h2>About</h2>
            <p class="close-disciplina-modal-btn">X</p>
        </div>
        <div class="contenido-modal-disciplina-container">
            <h3 class="nombre-disciplina-details-modal" id="disciplina-info-nombre"></h3>
            <p class="texto-disciplina-details-modal" id="disciplina-info-descripcion"></p>
        </div>
    </section>

    <dialog close>
        <p id="close-dialog-btn">X</p>
        <div class="">
            <div class="icono-texto-reserva">
                <img class="icono-reserva" src="assets/images/svg/reservado.svg"
                    alt="Clase reservada ícono">
                <p>Clase reservada</p>
            </div>
            <div class="icono-texto-reserva">
                <img class="icono-reserva" src="assets/images/svg/full_class.svg"
                    alt="Clase llena ícono">
                <p>Clase llena</p>
            </div>
            <div class="icono-texto-reserva">
                <img class="icono-reserva" src="assets/images/svg/waiting_list.svg"
                    alt="Lista de  ícono">
                <p>Lista de Espera</p>
            </div>
            <div class="icono-texto-reserva">
                <img class="aforo-icono" src="assets/images/svg/people-sharp.svg" alt="Aforo ícono">
                <p>Aforo</p>
            </div>
            <div class="icono-texto-reserva">
                <svg xmlns="http://www.w3.org/2000/svg" class="ionicon clase-en-curso-punto"
                    viewBox="0 0 512 512">
                    <defs>
                        
                    </defs>
                    <title>Ellipse</title>
                    <path style="fill: #986C5D;"
                        d="M256 464c-114.69 0-208-93.31-208-208S141.31 48 256 48s208 93.31 208 208-93.31 208-208 208z" />
                </svg>
                <p>Clase en curso</p>
            </div>
            <div class="icono-texto-reserva">
                <svg xmlns="http://www.w3.org/2000/svg" class="ionicon clase-en-curso-punto"
                    viewBox="0 0 512 512">
                    <defs>
                        
                    </defs>
                    <title>Ellipse</title>
                    <path style="fill: #00D52B;"
                        d="M256 464c-114.69 0-208-93.31-208-208S141.31 48 256 48s208 93.31 208 208-93.31 208-208 208z" />
                </svg>
                <p>Disponible</p>
            </div>
            <div class="icono-texto-reserva">
                <svg xmlns="http://www.w3.org/2000/svg" class="ionicon clase-en-curso-punto"
                    viewBox="0 0 512 512">
                    <defs>
                        
                    </defs>
                    <title>Ellipse</title>
                    <path style="fill: #ACACAC;"
                        d="M256 464c-114.69 0-208-93.31-208-208S141.31 48 256 48s208 93.31 208 208-93.31 208-208 208z" />
                </svg>
                <p>Cerrada</p>
            </div>
        </div>
    </dialog>

    <?php include 'footer.php'; ?>
    <script src="./assets/js/script.js?v=<?php echo time(); ?>"></script> 
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <?php include 'script.php'; ?>
</body>

</html>