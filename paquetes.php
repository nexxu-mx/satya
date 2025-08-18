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
  <link
    href="https://fonts.googleapis.com/css2?family=Oswald:wght@500;700&family=Rubik:wght@400;500;700&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="./assets/css/style.css?v=<?php echo time(); ?>">
  <?php include 'head.php'; ?>
  <style>
    
    .dsco{
      position: absolute;
      top: -10px;
      right: -14px;
      padding: 12px;
      background: #BFA187;
      font-size: 20px;
      border-radius: 50%;
      color: #fff;
      box-shadow: 0px 2px 12px #00000038;
    }
  </style>
</head>

<body id="top">
  <div class="preloader" data-preloader>
    <div class="circle"></div>
  </div>

  <?php include 'ofer.php'; ?>
  <?php include 'header.php'; ?>

  <main class="main-paquetes">
    <article>
      <section class="main-section-paquetes section">
        <div class="container">
          <h1>Paquetes</h1>
          <div class="loto"><img src="./assets/img/icono_loto.svg"  alt=""></div>
          
          <div class="inputs-container">
            <div class="buscar-input-container">
              <input type="text" placeholder="BUSCAR">
              <img src="assets/images/svg/search.svg" alt="search icon">
            </div>
            <select name="clases" id="clases-input">
              <option value="" selected>Todos</option>
              <option value="Movement">Movement</option>
              <option value="Pilates Reformer" >Pilates Reformer</option>
              <option value="Mixto" >Mixto</option>
            </select>
            
          </div>
          <section class="section membresias-section membresias-paquetes" style="background: none">
            <div class="container">
              <div class="cards-container">

              </div>
            </div>
          </section>
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
document.addEventListener("DOMContentLoaded", () => {
  const cardsContainer = document.querySelector(".cards-container");
  const searchInput = document.querySelector(".buscar-input-container input");
  const clasesInput = document.querySelector("#clases-input");

  const colores = ["var(--c6)", "var(--c2)", "var(--c8)", "var(--c7)"];

  function generarToken(longitud = 132) {
    const caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    let token = '';
    for (let i = 0; i < longitud; i++) {
      token += caracteres.charAt(Math.floor(Math.random() * caracteres.length));
    }
    return token;
  }

  const fetchPaquetes = () => {
    const params = new URLSearchParams({
      search: searchInput.value.trim(),
      clases: clasesInput.value
    });

    fetch(`get_paquetes.php?${params.toString()}`)
      .then(res => res.json())
      .then(data => {
        cardsContainer.innerHTML = "";
        if (data.length === 0) {
          cardsContainer.innerHTML = "<p>No se encontraron paquetes.</p>";
          return;
        }

        data.forEach((p, index) => {
          const card = document.createElement("div");
          card.className = "card";

          const token = generarToken();
          let colorActual 

          if(p.nombre == "Movement"){
            colorActual = "var(--c6)";

          }else if(p.nombre == "Mixto"){
            colorActual = "var(--c7)";
          }else{
            colorActual = "var(--c2)";
          }

          function descripcionPersona(p) {
            if (p.persona == 1) return 'Individual';
            if (p.persona == 2) return '2 Personas';
            if (p.persona == 4) return '4 Personas';
            return '';
          }
           if(p.nombre == "Movement"){
           const colorActual = "var(--c6)";

          }else if(p.nombre == "Mixto"){
            const colorActual = "var(--c8)";
          }else{
             const colorActual = "var(--c2)";
          }
          let descuento = "";
          let precio = `<p class="precio-card">$${Math.floor(p.costo)}<small>MX</small></p>`;

          if (typeof p.descuento !== 'undefined' && p.descuento !== null) {
            descuento = `<p class="dsco">${p.descuento}%</p>`;
            const dell = `<del style="color: #a0a0a0;">$${p.costo}</del>`;
            const costodesc = (p.costo / 100) * p.descuento;
            const costonvo = (p.costo - costodesc);
            precio = dell + `<p class="precio-card" style="margin-top: -20px;">$${costonvo}<small>MX</small></p>`;
          }

          card.innerHTML = `
            <p class="numero-clases-card" style="color: ${colorActual};  ${(p.clases == 'ILIMITADO' || p.clases == 'ANUALIDAD') ? 'font-size: 3.3rem; margin-block: 10px; margin-top: 30%;' : ''}">${p.clases}</p>
            <p class="clases-card" style="color: ${colorActual};">${(p.clases == 'ILIMITADO' || p.clases == 'ANUALIDAD') ? ' ' : 'Clases'}</p>
            <p class="clases-card" style="font-size: 2rem;">${p.nombre}</p>
            <p class="vigencia-card" style="margin-top: 0">
              Vigencia ${
                p.vigencia === 365 
                  ? 'Anual' 
                  : p.vigencia > 30 
                    ? Math.round(p.vigencia / 30) + ' meses' 
                    : p.vigencia + ' días'
              }
            </p>
            ${descuento}
            <div class="coust" style="background: ${colorActual}">
              ${precio}
              <a href="checkout.php?tkn=${token}&id=${p.id}">COMPRAR</a>
            </div>
          `;
          cardsContainer.appendChild(card);
        });
      });
  };

  searchInput.addEventListener("input", () => {
    setTimeout(fetchPaquetes, 300);
  });
  clasesInput.addEventListener("change", fetchPaquetes);

  fetchPaquetes();
});
</script>


</body>

</html>