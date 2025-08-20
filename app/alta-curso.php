<?php

session_start();
if (!isset($_SESSION['idUser']) || !isset($_SESSION['tipoUser'])) {

    header("Location: ../login.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>SenciaApp</title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <link rel="icon" href="./favico.png" type="image/x-icon" />
    <script src="./assets/js/plugin/webfont/webfont.min.js"></script>
    <script>
        WebFont.load({
            google: {
                "families": ["Public Sans:300,400,500,600,700"]
            },
            custom: {
                "families": ["Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"],
                urls: ['./assets/css/fonts.min.css']
            },
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="./assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/css/plugins.min.css">
    <link rel="stylesheet" href="./assets/css/next.min.css">

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="./assets/css/demo.css">
    <style>
        .icon {
            fill: #fff;
            width: 60px;
        }
    </style>
</head>

<body>
    <div class="wrapper sidebar_minimize">
        <!-- Sidebar -->
        <?php include 'sidebar.php'; ?>
        <!-- End Sidebar -->

        <div class="main-panel">
            <?php include 'navbar.php'; ?>

            <div class="container">
                <div class="page-inner">
                    <div class="page-header">
                        <h3 class="fw-bold mb-3">Agregar Disciplina</h3>
                        <ul class="breadcrumbs mb-3">
                            <li class="nav-home">
                                <a href="index.php">
                                    <i class="icon-home"></i>
                                </a>
                            </li>
                            <li class="separator">
                                <i class="icon-arrow-right"></i>
                            </li>
                            <li class="nav-item">
                                <a href="diciplinas.php">Disciplinas</a>
                            </li>
                            <li class="separator">
                                <i class="icon-arrow-right"></i>
                            </li>
                            <li class="nav-item">
                                <a href="#">Agregar Disciplina</a>
                            </li>

                        </ul>
                    </div>
                    <div id="form-disc" class="container-sm w-50 form-control p-5 mt-5">
                        <form action="procesar_disciplina.php" method="POST" enctype="multipart/form-data">
                            <?php
                            include '../db.php';

                            if (isset($_GET['id'])) {
                               
                                $idDisciplinaEdit = $_GET['id'];

                                $selectDisciplina = $conn->prepare("SELECT id, nombre_disciplina, descripcion_disciplina, subdescripcion_texto1, subdescripcion_texto2, subdescripcion_texto3, aforo, esp, activo FROM disciplinas WHERE id = ?");
                                $selectDisciplina->bind_param("i", $idDisciplinaEdit);
                                $selectDisciplina->execute();
                                $resultadoSelectDisciplina = $selectDisciplina->get_result();

                                $filaSelectDisciplina = $resultadoSelectDisciplina->fetch_assoc();

                                $button = "Guardar Edición";
                                $nombreDisciplina = $filaSelectDisciplina['nombre_disciplina'];
                                $descDisc = $filaSelectDisciplina['descripcion_disciplina'];
                                $subdesctext1 = $filaSelectDisciplina['subdescripcion_texto1'];
                                $subdesctext2 = $filaSelectDisciplina['subdescripcion_texto2'];
                                $subdesctext3 = $filaSelectDisciplina['subdescripcion_texto3'];
                                $aforo = $filaSelectDisciplina['aforo'];
                                $activo = $filaSelectDisciplina['activo'];
                                $esp = $filaSelectDisciplina['esp'];

                                if($esp == 1){
                                    $selectEsp = '<div class="form-group form-group-default">
                                                <label for="esp">Tipo de Lugar</label>
                                                <select class="form-select" id="esp" name="esp">
                                                    <option value="0">Ninguno</option>
                                                    <option value="1" selected="">Mat</option>
                                                    <option value="2">Reformer</option>
                                                </select>
                                            </div>';
                                }elseif($esp == 2){
                                    $selectEsp = '<div class="form-group form-group-default">
                                                <label for="esp">Tipo de Lugar</label>
                                                <select class="form-select" id="esp" name="esp">
                                                    <option value="0">Ninguno</option> 
                                                    <option value="1">Mat</option>
                                                    <option value="2" selected="">Reformer</option>
                                                </select>
                                            </div>';
                                }else{
                                    $selectEsp = '<div class="form-group form-group-default">
                                                <label for="esp">Tipo de Lugar</label>
                                                <select class="form-select" id="esp" name="esp">
                                                    <option value="0" selected="">Ninguno</option>
                                                    <option value="1">Mat</option>
                                                    <option value="2">Reformer</option>
                                                </select>
                                            </div>';
                                }

                            } else{
                                $button = "Agregar Disciplina";
                                $nombreDisciplina = "";
                                $descDisc = "";
                                $subdesctext1 = "";
                                $subdesctext2 = "";
                                $subdesctext3 = "";
                                $idCoach = "";
                                $activo = "";
                                $aforo = "";
                                $idDisciplinaEdit = "0";
                                
                                $selectEsp = '<div class="form-group form-group-default">
                                                <label for="esp">Tipo de Lugar</label>
                                                <select class="form-select" id="esp" name="esp">
                                                    <option value="0" selected="">Ninguno</option>
                                                    <option value="1">Mat</option>
                                                    <option value="2">Reformer</option>
                                                </select>
                                            </div>';
                            }
                            ?>
                            <input type="text" id="nombre_disc" name="nombre_disc" placeholder="Nombre de la Disciplina..." class="form-control mb-3 input-group input-group-lg p-3 bg-body-secondary" value="<?php echo $nombreDisciplina;?>" required>
                                    <textarea name="desc_disc" id="desc_disc" class="form-control no-resize mb-3 p-3 bg-body-secondary" required><?php echo $descDisc;?></textarea>

                                    <div class="d-flex justify-content-lg-center gap-3 mb-3">
                                        <input type="text" id="palabra-desc-1" name="palabra-desc-1" class="p-3 flex-fill form-control bg-body-secondary" value="<?php echo $subdesctext1; ?>" placeholder="Keyword" required>
                                        <input type="text" id="palabra-desc-2" name="palabra-desc-2" class="p-3 flex-fill form-control bg-body-secondary" value="<?php echo $subdesctext2; ?>" placeholder="Keyword" required>
                                        <input type="text" id="palabra-desc-3" name="palabra-desc-3" class="p-3 flex-fill form-control bg-body-secondary" value="<?php echo $subdesctext3; ?>" placeholder="Keyword" required>
                                    </div>
                                    <?php echo $selectEsp;?>
                                    <input type="text" id="aforo" name="aforo" class="form-control p-3 bg-body-secondary" placeholder="Aforo" value="<?php echo $aforo; ?>" required>
                                    <label for="imagen" class="my-3">SUBE UN VIDEO DE LA DISCIPLINA</label>
                                    <input type="file" id="imagen-disciplina" name="imagen-disciplina" class="form-control mt-0 p-3 bg-body-secondary" accept=".mp4,.mov,.avi,.wmv" onchange="mostrarVistaPrevia(event)" >
                                    <div class="d-flex justify-content-center">
                                        <video id="vistaPrevia" style="max-width: 50%; margin-top: 20px;" autoplay muted></video>
                                    </div>
                                    <input type="hidden" value="<?php echo $idDisciplinaEdit; ?>" id="id_disciplina_edit" name="id_disciplina_edit"/>
                            <div class="d-flex justify-content-center mt-3">
                            <button type="submit" class="btn btn-primary"><?php echo $button; ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>



            <footer class="footer">
                <div class="container-fluid">
                    <nav class="pull-left">
                        <ul class="nav">
                            <li class="nav-item">
                                <a class="nav-link" href="http://www.nexxu.mx">
                                    Soporte
                                </a>
                            </li>

                        </ul>
                    </nav>
                    <div class="copyright ms-auto">
                        <a href="http://www.nexxu.mx"><img src="https://nexxu.mx/./assets/images/logo-n.svg" style="width: 80px;" alt=""></a>
                    </div>
                </div>
            </footer>
        </div>


    </div>
    <script src="./assets/js/core/jquery-3.7.1.min.js"></script>
    <script src="./assets/js/core/popper.min.js"></script>
    <script src="./assets/js/core/bootstrap.min.js"></script>
    <script src="./assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
    <script src="./assets/js/plugin/chart.js/chart.min.js"></script>
    <script src="./assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>
    <script src="./assets/js/plugin/chart-circle/circles.min.js"></script>
    <script src="./assets/js/plugin/datatables/datatables.min.js"></script>
    <script src="./assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>
    <script src="./assets/js/plugin/sweetalert/sweetalert.min.js"></script>
    <script src="./assets/js/next.min.js"></script>

    <script>
        function mostrarVistaPrevia(event) {
            const video = document.getElementById('vistaPrevia');
            video.src = URL.createObjectURL(event.target.files[0]);
        }
    </script>

</body>

</html>