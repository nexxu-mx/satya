     const stripe = Stripe('pk_live_51S5pDhACpsQBnThKpjEDD2cmOeOfsSFRFgz1qjIUbeA9FFy475VF9aK1cl0nmx0sxCQ6g1usDKJ0D0wwhpfX4XBr00DkkzhBYV'); 
    //  TEST:::pk_test_51S5pGNAL9Ya1TisEQBgkgxi6GQWt4zPAwKS1lL16B1an498FV7utx4o42DagKOFKmydNHdVx13bAwQzp1OmSdKBn00VW1A7Oum
const elements = stripe.elements();
const card = elements.create('card');
card.mount('#card-element');

const form = document.getElementById('payment-form');
form.addEventListener('submit', async (e) => {
    e.preventDefault();

    // Pedir al backend el client secret
    const {clientSecret} = await fetch('create_payment_stripe.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
    }).then(r => r.json());

    const {error, paymentIntent} = await stripe.confirmCardPayment(clientSecret, {
        payment_method: {
            card: card
        }
    });
    const resqueElement = document.getElementById("resque");
    if (error) {
        document.getElementById('data-pago').style.display = 'none';
        document.getElementById('metodo_pago').style.display = 'none';

                 // Plantillas para cada estado
                resqueElement.innerHTML = `
                <div class="success-message">
                    <div style="display: flex; justify-content: center;">
                        <img src="./assets/images/revoque.svg" alt="Pago rechazado" style="width: 100px;">
                    </div>
                    <h2 style="color: var(--light-brown-3);">¡Compra Rechazada!</h2>
                    <p>${error.message}</p>
                    <a href="checkout.php" style="margin-top: 25px" class="c3">Reintentar</a>
                </div>`;
    } else{
        fetch("success_payment.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body: `status=${encodeURIComponent(paymentIntent.status)}&id=${encodeURIComponent(paymentIntent.id)}`
    })
      .then(response => response.json())
      .then(data => {
                if(data.payment_status == 'approved'){
                        document.getElementById('data-pago').style.display = 'none';
                        document.getElementById('metodo_pago').style.display = 'none';

                        // Elemento donde mostraremos el resultado
                        
                        // Plantillas para cada estado
                        resqueElement.innerHTML = `
                        <div class="success-message">
                            <div style="display: flex; justify-content: center;">
                                <img src="./assets/images/checkmark.svg" alt="Checkmark" style="width: 100px;">
                            </div>
                            <h2 style="color: var(--light-brown-3);">¡Compra Aprobada!</h2>
                            <p>Tu compra ha sido exitosa.</p>
                            <h3 style="color: var(--light-browm-2);">ID de pago: ${data.payment_id}</h3>
                            <h4 style="font-weight: 300; font-size: 1.5rem; line-height: 1;">
                                ¡Gracias por tu compra! En breve recibirás un mensaje de confirmación con tu recibo de pago.
                            </h4>
                            <a href="profile.php" style="margin-top: 25px" class="c3">Ir a Perfil</a>
                        </div>`;
                }else if($data.error === "CLASE BIENVENIDA UTILIZADA"){
                     document.getElementById('data-pago').style.display = 'none';
                     document.getElementById('metodo_pago').style.display = 'none';
                        
                        // Plantillas para cada estado
                        resqueElement.innerHTML = `
                        <div class="success-message">
                            <div style="display: flex; justify-content: center;">
                                <img src="./assets/images/revoque.svg" alt="Error en pago" style="width: 100px;">
                            </div>
                            <h2 style="color: var(--light-brown-3);">¡Ocurrió un Error!</h2>
                            <p>No puedes volver a adquirir una clase de prueba, porque solo se puede comprar una sola vez.</p>
                            <a href="paquetes.php" style="margin-top: 25px" class="c3">Comprar otro paquete</a>
                        </div>`;
                } else {
                    document.getElementById('data-pago').style.display = 'none';
                    document.getElementById('metodo_pago').style.display = 'none';
                        
                        // Plantillas para cada estado
                        resqueElement.innerHTML = `
                         <div class="success-message">
                            <div style="display: flex; justify-content: center;">
                                <img src="./assets/images/revoque.svg" alt="Error en pago" style="width: 100px;">
                            </div>
                            <h2 style="color: var(--light-brown-3);">¡Ocurrió un Error!</h2>
                            <p>Vuelve a intentar el pago nuevamente.</p>
                            <a href="checkout.php" style="margin-top: 25px" class="c3">Reintentar</a>
                        </div>`;
                }
      })
      .catch(error => {
        console.error("Error:", error);
      });

    }
    resqueElement.style.display = 'flex';
});