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
    <title>SATYA App</title>
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
    <style>
#video {
width: 100%; height: 100%; border: dotted 1px #999;display: flex;justify-content: center;align-items: center;color: #999; position: relative; z-index: 0;
}
#video.dragover {
  border-color: #007bff;
  color: #007bff;
}
#miniature {
    width: auto;height: 100%; border: dotted 1px #999;display: flex; justify-content: center;align-items: center;color: #999; position: relative; z-index: 0;
}
#miniature.dragover {
  border-color: #28a745;
  color: #28a745;
}
#miniature img {
  width: 100%;
  height: 100%;
  object-fit: cover;
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
                        <h3 class="fw-bold mb-3">E-Learning</h3>
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
                                <a href="diciplinas.php">Clases</a>
                            </li>
                            <li class="separator">
                                <i class="icon-arrow-right"></i>
                            </li>
                            <li class="nav-item">
                                <a href="#">Nueva Clase</a>
                            </li>

                        </ul>
                    </div>
                    <div id="form-disc" style="display: flex; justify-content: center;">
                        <form action="procesar_online.php" style="max-width: 545px" method="POST" enctype="multipart/form-data">
                            <?php
                            include '../db.php';

                            if (isset($_GET['id'])) {
                               
                            } else{
                              
                               
                            }
                            ?>
                                <div class="col-md-12">
                                    <div class="card card-post card-round">
                                        <div style="height: 330px; background: #f0f0f0; overflow: hidden; display: flex; align-items: center;justify-content: center; position: relative" >
                                              <div id="video">+ Agrega Video</div>       
                                        </div>
                                            <input type="file" id="videoFile" name="videoFile" accept="video/mp4" hidden>
                                            <input type="hidden" id="videoInput">
                                            <input type="file" id="miniatureFile" name="miniatureFile" accept="image/png" hidden>
                                            <input type="hidden" id="miniatureInput">
                                        <div class="card-body" style="position: relative">
                                            <div style="position: absolute; top: 10px; z-index: 5;width: 190px;height: 120px;box-shadow: 0 0 12px #0000009e; right: -15px;background: #eee;" >
                                                    <div id="miniature">+ Agrega miniatura</div>
                                                </div>
                                            <div class="d-flex">
                                                <div class="avatar">
                                                    <img src="../assets/images/unknow.jpg" alt="..." class="avatar-img rounded-circle">
                                                </div>
                                                
                                                <div class="info-post ms-2">
                                                    <select name="type" id="type" class="form-select username">
                                                        <option value="pilates_mat">Pilates Mat</option>
                                                        <option value="yoga">Yoga</option>
                                                        <option value="barre">Barre</option>
                                                        <option value="pilates_reformer">Pilates Reformer</option>
                                                    </select>
                                                    
                                                    
                                                </div>
                                            </div>
                                            <div class="separator-solid"></div>
                                            <select name="level" id="level" class="form-select card-category text-info" style="border: none;width: auto;">
                                                <option value="Principiante">Principiante</option>
                                                <option value="Amateur">Amateur</option>
                                                <option value="Intermedio">Intermedio</option>
                                                <option value="Avanzado">Avanzado</option>
                                            </select>
                                            <input type="text" class="card-title" name="title" id="title" placeholder="Título de la clase..." style="width: 100%;border: none;" required>
                                            <textarea name="description" id="description" class="card-text" placeholder="Descripción de la clase..." style="width: 100%;height: 120px;border: none;" required></textarea>
                                           <input type="text" name="equipment" id="equipment" placeholder="Equipamiento..." style="width: 100%;margin-block: 30px;border: none;" required>
                                            <div>
                                                <button type="submit" class="btn btn-primary btn-rounded btn-sm">Guardar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

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
document.addEventListener("DOMContentLoaded", function() {

  // ---------- VIDEO ----------
  const dropVideo = document.getElementById("video");
  const fileVideo = document.getElementById("videoFile");

  // Abrir selector de archivo al tocar/click
  dropVideo.addEventListener("click", () => fileVideo.click());

  // Previsualizar video
  function previewVideo(file) {
    if (!file || file.type !== "video/mp4") {
      alert("Selecciona un archivo en formato MP4");
      return;
    }

    const url = URL.createObjectURL(file);
    dropVideo.innerHTML = `
      <video controls width="100%" height="100%" style="object-fit: cover;">
        <source src="${url}" type="video/mp4">
      </video>
    `;
  }

  // Drag & drop
  dropVideo.addEventListener("dragover", e => { e.preventDefault(); dropVideo.classList.add("dragover"); });
  dropVideo.addEventListener("dragleave", e => { dropVideo.classList.remove("dragover"); });
  dropVideo.addEventListener("drop", e => {
    e.preventDefault();
    dropVideo.classList.remove("dragover");
    const file = e.dataTransfer.files[0];
    if (file) {
      previewVideo(file);
      fileVideo.files = e.dataTransfer.files; // esto sí funciona aquí: el input recibe el archivo arrastrado
    }
  });

  // Selección manual
  fileVideo.addEventListener("change", e => {
    const file = e.target.files[0];
    previewVideo(file);
  });


  // ---------- MINIATURA ----------
  const dropImg = document.getElementById("miniature");
  const fileImg = document.getElementById("miniatureFile");

  // Abrir selector al tocar/click
  dropImg.addEventListener("click", () => fileImg.click());

  // Previsualizar imagen
  function previewImage(file) {
    if (!file || file.type !== "image/png") {
      alert("Selecciona una imagen PNG");
      return;
    }
    const url = URL.createObjectURL(file);
    dropImg.innerHTML = `<img src="${url}" alt="Miniatura" style="max-width:100%; max-height:100%; object-fit:contain;">`;
  }

  // Drag & drop
  dropImg.addEventListener("dragover", e => { e.preventDefault(); dropImg.classList.add("dragover"); });
  dropImg.addEventListener("dragleave", e => { dropImg.classList.remove("dragover"); });
  dropImg.addEventListener("drop", e => {
    e.preventDefault();
    dropImg.classList.remove("dragover");
    const file = e.dataTransfer.files[0];
    if (file) {
      previewImage(file);
      fileImg.files = e.dataTransfer.files; // el input recibe el archivo arrastrado
    }
  });

  // Selección manual
  fileImg.addEventListener("change", e => {
    const file = e.target.files[0];
    previewImage(file);
  });

});
</script>

</body>

</html>