
// Sistema de navegación por estados sin regreso
let currentState = 1; // Estado inicial (select1)

// Empuja un estado inicial al cargar
history.replaceState({page: currentState}, "", location.href);

window.addEventListener("popstate", function (event) {
    const select1 = document.getElementById('select1');
    const select2 = document.getElementById('select2');
    const select3 = document.getElementById('select3');
    
    
    // Prevenir el regreso empujando el estado actual de nuevo
    history.pushState({page: currentState}, "", location.href);
    
    setTimeout(() => {
        // Mostrar la sección correcta según el estado actual
        switch(currentState) {
            case 1: // Mostrar select1                
                select1.classList.remove("inicio-online-active");
                select2.classList.remove("eleccion-online-active");
                setTimeout(() => {
                            select2.style.display = "none";
                            select1.style.display = "block";
                        }, 100);
                break;
                
            case 2: // Mostrar select2
                
                select2.classList.add("eleccion-online-active");
                select3.classList.remove("class-online-select-active");
                setTimeout(() => {
                            select2.style.display = "block";
                            select3.style.display = "none";
                        }, 100);
                goToSelect1();
                break;
                
            case 3: // Mostrar select3
                select1.style.display = "none";
                select1.classList.remove("inicio-online-active");
                select2.style.display = "none";
                select2.classList.remove("eleccion-online-active");
                select3.style.display = "block";
                select3.classList.add("class-online-select-active");
                break;
        }
    }, 50);
});

// Funciones para cambiar de estado (llama estas cuando el usuario avance)
function goToSelect1() {
    currentState = 1;
    history.pushState({page: 1}, "", location.href);
    // Aquí puedes agregar la lógica para mostrar select1
}

function goToSelect2() {
    currentState = 2;
    history.pushState({page: 2}, "", location.href);
    // Aquí puedes agregar la lógica para mostrar select2
}

function goToSelect3() {
    currentState = 3;
    history.pushState({page: 3}, "", location.href);
    // Aquí puedes agregar la lógica para mostrar select3
}




 function playClassPreview() {
    const previews = document.querySelectorAll(".preview-class-vid");

    previews.forEach(preview => {
        const video = preview.querySelector("video");
        const btn = preview.querySelector(".btnplay");

        // Ocultar controles del video
        video.removeAttribute("controls");

        // Configurar para iOS
        video.setAttribute("playsinline", "true");
        video.setAttribute("webkit-playsinline", "true");
        video.setAttribute("preload", "metadata");

        // Detectar si es iOS
        const isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;

        btn.addEventListener("click", (e) => {
            e.stopPropagation();
            
            if (isIOS) {
                // Estrategia especial para iOS
                video.setAttribute("controls", "true");
                video.play().then(() => {
                    btn.style.display = "none";
                    // Ocultar controles nativos después de iniciar
                    setTimeout(() => {
                        video.removeAttribute("controls");
                    }, 1000);
                }).catch(error => {
                    console.log("Error iOS:", error);
                    video.setAttribute("controls", "true");
                });
            } else {
                // Para otros dispositivos
                video.play().then(() => {
                    btn.style.display = "none";
                }).catch(error => {
                    console.log("Error:", error);
                    video.setAttribute("controls", "true");
                });
            }
        });

        // Eventos para restaurar el botón
        video.addEventListener("pause", () => {
            btn.style.display = "block";
        });

        video.addEventListener("ended", () => {
            btn.style.display = "block";
        });

        // Click fuera del video
        document.addEventListener("click", (e) => {
            if (!preview.contains(e.target) && !video.paused) {
                video.pause();
                btn.style.display = "block";
            }
        });
    });
}

///botn like



async function initializeLikeButtons() {
    const likeButtons = document.querySelectorAll('.like-btn');

    likeButtons.forEach(async (button) => {
        const postId = button.dataset.postId; // más corto que getAttribute

        try {
            // Llamada al backend
            const response = await fetch('like_user.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json' // enviamos JSON
                },
                body: JSON.stringify({ postId })
            });

            if (!response.ok) throw new Error("Error en la petición");

            const data = await response.json();

            let isLiked;
            if (data.success) {
                // el backend confirma si está likeado
                isLiked = data.response === true;
            } else {
                // fallback a localStorage
                isLiked = localStorage.getItem(`like_${postId}`) === 'true';
            }

            // actualizar UI
            updateLikeUI(button, isLiked);

        } catch (error) {
            console.warn("Error al validar like en servidor:", error);
            // fallback a localStorage
            const isLiked = localStorage.getItem(`like_${postId}`) === 'true';
            updateLikeUI(button, isLiked);
        }

        // siempre agregamos el evento click
        button.addEventListener('click', function () {
            handleLikeClick(this);
        });
    });
}


function handleLikeClick(button) {
    const postId = button.getAttribute('data-post-id');
    const isCurrentlyLiked = localStorage.getItem(`like_${postId}`) === 'true';
    const newLikeState = !isCurrentlyLiked;
    
    // Enviar petición al servidor
    sendLikeToServer(postId, newLikeState);
    
    // Actualizar UI inmediatamente (optimistic update)
    updateLikeUI(button, newLikeState);
    
    // Actualizar localStorage
    if (newLikeState) {
        localStorage.setItem(`like_${postId}`, 'true');
    } else {
        localStorage.removeItem(`like_${postId}`);
    }
}

function updateLikeUI(button, isLiked) {
    const heartIcon = button.querySelector('.heart-icon');
    const path = heartIcon.querySelector('path');
    
    if (isLiked) {
        path.style.fill = 'red';
        button.setAttribute('data-liked', 'true');
    } else {
        path.style.fill = ''; // Volver al color por defecto
        button.setAttribute('data-liked', 'false');
    }
}

function sendLikeToServer(postId, likeState) {
    // Crear FormData para enviar los datos
    const formData = new FormData();
    formData.append('post_id', postId);
    formData.append('action', likeState ? 'like' : 'unlike');
    
    // Enviar petición fetch
    fetch('like_handler.php', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Error en la respuesta del servidor');
        }
        return response.json();
    })
    .then(data => {
        if (!data.success) {
            // Revertir cambios si hay error
            const button = document.querySelector(`.like-btn[data-post-id="${postId}"]`);
            const currentState = localStorage.getItem(`like_${postId}`) === 'true';
            updateLikeUI(button, !currentState);
            
            console.error('Error:', data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        // Revertir cambios en caso de error
        const button = document.querySelector(`.like-btn[data-post-id="${postId}"]`);
        const currentState = localStorage.getItem(`like_${postId}`) === 'true';
        updateLikeUI(button, !currentState);
    });
}

// Función para verificar si un post está likeado
function isPostLiked(postId) {
    return localStorage.getItem(`like_${postId}`) === 'true';
}

// Función para obtener todos los posts likeados
function getAllLikedPosts() {
    const likedPosts = [];
    for (let i = 0; i < localStorage.length; i++) {
        const key = localStorage.key(i);
        if (key.startsWith('like_') && localStorage.getItem(key) === 'true') {
            const postId = key.replace('like_', '');
            likedPosts.push(postId);
        }
    }
    return likedPosts;
}
//funcion para mostrar previews de clases


let allClasses = []; // cache local para evitar recargar del PHP

// Función principal para obtener y mostrar clases
async function loadClasses(mode,type, name) {
    goToSelect1();
   ///scroll top

   function smoothScrollToTop(duration = 400) {
    const scrollTarget = document.scrollingElement || document.documentElement;
    const start = scrollTarget.scrollTop;
    const startTime = performance.now();

    function scroll() {
        const now = performance.now();
        const time = Math.min(1, (now - startTime) / duration);
        scrollTarget.scrollTop = start * (1 - time);
        if (time < 1) requestAnimationFrame(scroll);
    }

    scroll();
}

smoothScrollToTop(500);


    const inicio = document.getElementById('select1');
    const eleccion = document.getElementById('select2');
    const container = document.getElementById("showclass");
    document.getElementById('type-class-online').innerText = name;

    inicio.classList.add("inicio-online-active");
    eleccion.style.display = "block"
    setTimeout(() => {
    inicio.style.display = "none";
    eleccion.classList.add("eleccion-online-active");
    
    }, 100);

    

    container.innerHTML = renderSkeletons(6); // mostrar skeletons mientras carga


    try {
        const response = await fetch(`get-class-online.php?type=${encodeURIComponent(type)}&mode=${encodeURIComponent(mode)}`);
        const data = await response.json();

        allClasses = data; // guardamos para búsquedas locales
        renderClasses(data);
        setupLazyLoading();
    } catch (error) {
        container.innerHTML = "<p>Error al cargar las clases.</p>";
        console.error(error);
    }
    playClassPreview();
    initializeLikeButtons();
}

// Renderiza tarjetas de clases
function renderClasses(classes) {
    const container = document.getElementById("showclass");
    if (!classes.length) {
        container.innerHTML = "<p>Aun no existe clases.</p>";
        return;
    }

    container.innerHTML = classes.map(cls => `
        <article class="class-online" onclick="viewClass(${cls.id})">
            <figure class="preview-class-vid">
                <video 
                    data-src="./online/${cls.id}.mp4"
                    preload="metadata"
                    playsinline
                    webkit-playsinline
                    poster="./online/${cls.id}.png"
                    disablePictureInPicture
                    controlsList="nodownload nofullscreen"
                ></video>
                <div class="progress">
                    <div class="progress-bar" style="width: ${cls.progress}%"></div>
                </div>
               <button id="btnplay" class="btnplay"> <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 80.04 80.04"><defs></defs><g id="Capa_2" data-name="Capa 2"><g id="Capa_1-2" data-name="Capa 1"><g class="cls-boton-online"><path class="cls-boton-online" d="M40,80A40,40,0,1,1,80,40,40.07,40.07,0,0,1,40,80ZM40,4.51A35.51,35.51,0,1,0,75.53,40,35.55,35.55,0,0,0,40,4.51Z"/><path class="cls-boton-online" d="M28,23.5v34a2.52,2.52,0,0,0,3.82,2.16L60.33,41.16a2.53,2.53,0,0,0,0-4.34L31.85,21.33A2.53,2.53,0,0,0,28,23.5Z"/></g></g></g></svg> </button>
            </figure>
            <div class="descripcion-online">
                <div class="info-on">
                    <h3>${cls.title}</h3>
                    <div class="inf-class">
                        <span class="time-on">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 27.42 27.42"><defs></defs><g id="Capa_2" data-name="Capa 2"><g id="Capa_1-2" data-name="Capa 1"><path class="time-svg" d="M13.71,27.42A13.71,13.71,0,1,1,27.42,13.71,13.73,13.73,0,0,1,13.71,27.42ZM13.71,2A11.71,11.71,0,1,0,25.42,13.71,11.72,11.72,0,0,0,13.71,2Z"/><path class="time-svg" d="M17.61,17.16l-4.5-3.36a1,1,0,0,1-.4-.8V6.8a1,1,0,0,1,1-1h0a1,1,0,0,1,1,1V12a1,1,0,0,0,.4.8l3.69,2.76A1,1,0,0,1,19,17h0A1,1,0,0,1,17.61,17.16Z"/></g></g></svg>
                            ${cls.duration} min
                        </span>
                        <p>${cls.level}, ${cls.equipment}</p>
                    </div>
                </div>
                <button class="like-btn" data-post-id="${cls.id}" data-liked="false">
                    <svg class="heart-icon" width="24" height="24" viewBox="0 0 24 24">
                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 
                                 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 
                                 3.41.81 4.5 2.09C13.09 3.81 14.76 
                                 3 16.5 3 19.58 3 22 5.42 
                                 22 8.5c0 3.78-3.4 6.86-8.55 
                                 11.54L12 21.35z"/>
                    </svg>
                </button>
            </div>
        </article>
    `).join("");
}

// Renderiza skeletons mientras carga
function renderSkeletons(count = 3) {
    return Array(count).fill().map(() => `
        <article class="class-online skeleton">
            <figure class="preview-class-vid">
                <div class="skeleton-thumb"></div>
            </figure>
            <div class="descripcion-online">
                <div class="skeleton-line"></div>
                <div class="skeleton-line short"></div>
            </div>
        </article>
    `).join("");
}

// Búsqueda local en el array cargado
document.getElementById("searclass").addEventListener("input", (e) => {
    const term = e.target.value.toLowerCase();
    const filtered = allClasses.filter(c => 
        c.title.toLowerCase().includes(term) || 
        c.level.toLowerCase().includes(term) || 
        c.equipment.toLowerCase().includes(term)
    );
    renderClasses(filtered);
    setupLazyLoading();
});

// Lazy loading para videos
function setupLazyLoading() {
    const videos = document.querySelectorAll("video[data-src]");
    const observer = new IntersectionObserver((entries, obs) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const video = entry.target;
                video.src = video.getAttribute("data-src");
                video.removeAttribute("data-src");
                obs.unobserve(video);
            }
        });
    }, { rootMargin: "100px" });

    videos.forEach(video => observer.observe(video));
}



///funciones para ver clases

function viewClassRel(id){
      ///scroll top

   function smoothScrollToTop(duration = 400) {
    const scrollTarget = document.scrollingElement || document.documentElement;
    const start = scrollTarget.scrollTop;
    const startTime = performance.now();

    function scroll() {
        const now = performance.now();
        const time = Math.min(1, (now - startTime) / duration);
        scrollTarget.scrollTop = start * (1 - time);
        if (time < 1) requestAnimationFrame(scroll);
    }

    scroll();
}

smoothScrollToTop(500);

    fetch('get-class-elearning.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'id=' + encodeURIComponent(id)
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Error en la respuesta');
        }
        return response.json();
    })
    .then(data => {
        const content = document.getElementById('content-class');
        content.innerHTML = "";
        document.getElementById('name-class-online').innerHTML = data.titulo;
         content.innerHTML = `
            <article class="class-online-sel">
                    <figure class="preview-class-vid" id="e-class">
                        <video controls poster="./online/${data.id}.png" playsinline webkit-playsinline preload="metadata" muted data-idvideo="${data.id}">
                            <source src="stream.php?id=${data.id}&token=${data.token}" type="video/mp4">
                        </video>
                    <button id="get-class" class="btnplay"> <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 80.04 80.04"><defs></defs><g id="Capa_2" data-name="Capa 2"><g id="Capa_1-2" data-name="Capa 1"><g class="cls-boton-online"><path class="cls-boton-online" d="M40,80A40,40,0,1,1,80,40,40.07,40.07,0,0,1,40,80ZM40,4.51A35.51,35.51,0,1,0,75.53,40,35.55,35.55,0,0,0,40,4.51Z"/><path class="cls-boton-online" d="M28,23.5v34a2.52,2.52,0,0,0,3.82,2.16L60.33,41.16a2.53,2.53,0,0,0,0-4.34L31.85,21.33A2.53,2.53,0,0,0,28,23.5Z"/></g></g></g></svg> </button>
                    </figure>
                    <div class="descripcion-online">
                        <div class="info-on">
                            <h3>${data.titulo}</h3>
                            <div class="inf-class">
                                <span class="time-on">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 27.42 27.42"><defs></defs><g id="Capa_2" data-name="Capa 2"><g id="Capa_1-2" data-name="Capa 1"><path class="time-svg" d="M13.71,27.42A13.71,13.71,0,1,1,27.42,13.71,13.73,13.73,0,0,1,13.71,27.42ZM13.71,2A11.71,11.71,0,1,0,25.42,13.71,11.72,11.72,0,0,0,13.71,2Z"/><path class="time-svg" d="M17.61,17.16l-4.5-3.36a1,1,0,0,1-.4-.8V6.8a1,1,0,0,1,1-1h0a1,1,0,0,1,1,1V12a1,1,0,0,0,.4.8l3.69,2.76A1,1,0,0,1,19,17h0A1,1,0,0,1,17.61,17.16Z"/></g></g></svg>
                                    ${data.duracion} min
                                </span>
                                <p>${data.nivel}, ${data.equipamiento}</p>
                            </div>
                        </div>
                        <button class="like-btn" data-post-id="3" data-liked="false">
                            <svg class="heart-icon" width="24" height="24" viewBox="0 0 24 24">
                                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 
                                        2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 
                                        3.41.81 4.5 2.09C13.09 3.81 14.76 
                                        3 16.5 3 19.58 3 22 5.42 
                                        22 8.5c0 3.78-3.4 6.86-8.55 
                                        11.54L12 21.35z"/>
                            </svg>
                        </button>
                    </div>
                </article>
                <div class="co1">
                    <button class="button-online-class"  >
                        <svg  class="heart-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 35.56 31.49"><g id="Capa_2" data-name="Capa 2"><g id="Capa_1-2" data-name="Capa 1"><path d="M18,31.49h-.51a50.94,50.94,0,0,1-11.77-9.3C1.63,17.69-2.12,10.62,1.4,4.69a9.75,9.75,0,0,1,16.33-.51c.13,0,.14-.08.2-.14a22.67,22.67,0,0,1,1.73-1.87A9.75,9.75,0,0,1,35.16,7c2.11,7.55-4.62,15.1-10,19.51A52.43,52.43,0,0,1,18,31.49ZM9,2A7.78,7.78,0,0,0,2.3,7.68C.15,15.8,10.49,24.74,16.56,28.56c.24.15,1.12.77,1.3.72,4.64-3,9.35-6.55,12.55-11.08C33,14.59,35,9.37,32.17,5.33a7.74,7.74,0,0,0-12.81.15c-.48.73-.88,2.42-2.08,1.75-.45-.25-.51-.78-.75-1.18A7.72,7.72,0,0,0,9,2Z"/></g></g></svg>
                        <span>Favorito</span>
                    </button>
                    <div class="button-online-class" >
                        <div class="complete-class ${data.completado}"></div>
                        <span>Completado</span>
                    </div>
                </div>
                <div class="co2">
                    <p>${data.descripcion}</p>
                        <span>${data.equipamiento}</span>
                </div>
        `;
        document.getElementById('recomendados').innerHTML = '';
        document.getElementById('recomendados').innerHTML = data.recomendados;
        initializeLikeButtons();
        protectvid();
        initVideoProgressTracking();
    })
    .catch(error => {
        console.error('Error:', error);
        document.getElementById('contenedor').innerHTML = 
            '<p>No se pudo cargar la clase, intente mas tarde.</p>';
    });
    
}

function viewClass(id){
    goToSelect2();
    document.getElementById('select2').classList.remove("eleccion-online-active");
    document.getElementById('select3').style.display = "block";
      setTimeout(() => {
        document.getElementById('select2').style.display = "none";
         document.getElementById('select3').classList.add("class-online-select-active");
    }, 100);
   
    fetch('get-class-elearning.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'id=' + encodeURIComponent(id)
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Error en la respuesta');
        }
        return response.json();
    })
    .then(data => {
        const content = document.getElementById('content-class');
        content.innerHTML = "";
        document.getElementById('name-class-online').innerHTML = data.titulo;
        if(data.activo == false){
            document.getElementById('cautivo').style.display = "flex";
        }
         content.innerHTML = `
            <article class="class-online-sel">
                    <figure class="preview-class-vid" id="e-class">
                        <video controls poster="./online/${data.id}.png" playsinline webkit-playsinline preload="metadata" muted data-idvideo="${data.id}">
                            <source src="stream.php?id=${data.id}&token=${data.token}" type="video/mp4">
                        </video>
                    <button id="get-class" class="btnplay"> <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 80.04 80.04"><defs></defs><g id="Capa_2" data-name="Capa 2"><g id="Capa_1-2" data-name="Capa 1"><g class="cls-boton-online"><path class="cls-boton-online" d="M40,80A40,40,0,1,1,80,40,40.07,40.07,0,0,1,40,80ZM40,4.51A35.51,35.51,0,1,0,75.53,40,35.55,35.55,0,0,0,40,4.51Z"/><path class="cls-boton-online" d="M28,23.5v34a2.52,2.52,0,0,0,3.82,2.16L60.33,41.16a2.53,2.53,0,0,0,0-4.34L31.85,21.33A2.53,2.53,0,0,0,28,23.5Z"/></g></g></g></svg> </button>
                    </figure>
                    <div class="descripcion-online">
                        <div class="info-on">
                            <h3>${data.titulo}</h3>
                            <div class="inf-class">
                                <span class="time-on">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 27.42 27.42"><defs></defs><g id="Capa_2" data-name="Capa 2"><g id="Capa_1-2" data-name="Capa 1"><path class="time-svg" d="M13.71,27.42A13.71,13.71,0,1,1,27.42,13.71,13.73,13.73,0,0,1,13.71,27.42ZM13.71,2A11.71,11.71,0,1,0,25.42,13.71,11.72,11.72,0,0,0,13.71,2Z"/><path class="time-svg" d="M17.61,17.16l-4.5-3.36a1,1,0,0,1-.4-.8V6.8a1,1,0,0,1,1-1h0a1,1,0,0,1,1,1V12a1,1,0,0,0,.4.8l3.69,2.76A1,1,0,0,1,19,17h0A1,1,0,0,1,17.61,17.16Z"/></g></g></svg>
                                    ${data.duracion} min
                                </span>
                                <p>${data.nivel}, ${data.equipamiento}</p>
                            </div>
                        </div>
                        <button class="like-btn" data-post-id="3" data-liked="false">
                            <svg class="heart-icon" width="24" height="24" viewBox="0 0 24 24">
                                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 
                                        2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 
                                        3.41.81 4.5 2.09C13.09 3.81 14.76 
                                        3 16.5 3 19.58 3 22 5.42 
                                        22 8.5c0 3.78-3.4 6.86-8.55 
                                        11.54L12 21.35z"/>
                            </svg>
                        </button>
                    </div>
                </article>
                <div class="co1">
                    <button class="button-online-class"  >
                        <svg  class="heart-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 35.56 31.49"><g id="Capa_2" data-name="Capa 2"><g id="Capa_1-2" data-name="Capa 1"><path d="M18,31.49h-.51a50.94,50.94,0,0,1-11.77-9.3C1.63,17.69-2.12,10.62,1.4,4.69a9.75,9.75,0,0,1,16.33-.51c.13,0,.14-.08.2-.14a22.67,22.67,0,0,1,1.73-1.87A9.75,9.75,0,0,1,35.16,7c2.11,7.55-4.62,15.1-10,19.51A52.43,52.43,0,0,1,18,31.49ZM9,2A7.78,7.78,0,0,0,2.3,7.68C.15,15.8,10.49,24.74,16.56,28.56c.24.15,1.12.77,1.3.72,4.64-3,9.35-6.55,12.55-11.08C33,14.59,35,9.37,32.17,5.33a7.74,7.74,0,0,0-12.81.15c-.48.73-.88,2.42-2.08,1.75-.45-.25-.51-.78-.75-1.18A7.72,7.72,0,0,0,9,2Z"/></g></g></svg>
                        <span>Favorito</span>
                    </button>
                    <div class="button-online-class" >
                        <div class="complete-class ${data.completado}"></div>
                        <span>Completado</span>
                    </div>
                </div>
                <div class="co2">
                    <p>${data.descripcion}</p>
                        <span>${data.equipamiento}</span>
                </div>
        `;
        document.getElementById('recomendados').innerHTML = '';
        document.getElementById('recomendados').innerHTML = data.recomendados;
        initializeLikeButtons();
        protectvid();
        initVideoProgressTracking();
    })
    .catch(error => {
        console.error('Error:', error);
        document.getElementById('contenedor').innerHTML = 
            '<p>No se pudo cargar la clase, intente mas tarde.</p>';
    });
    
}


/////////////////////////
function protectvid(){

    const videoContainer = document.getElementById('e-class');
    const video = videoContainer.querySelector('video');
    const playButton = document.getElementById('get-class');
    
    // 1. Ocultar controles nativos al inicio
    video.removeAttribute('controls');
    
    // 2. Configurar el video para prevenir descargas
    video.addEventListener('contextmenu', function(e) {
        e.preventDefault();
        return false;
    });
    
    // 3. Prevenir drag and drop de descarga
    video.addEventListener('dragstart', function(e) {
        e.preventDefault();
        return false;
    });
    
    // 4. Ocultar controles de descarga del navegador
    video.disablePictureInPicture = true;
    
    // 5. Mostrar botón play personalizado
    playButton.style.display = 'block';
    
    // 6. Evento para el botón play personalizado
    playButton.addEventListener('click', function() {
        // Ocultar botón play
        this.style.display = 'none';
        
        // Mostrar controles nativos y reproducir
        video.setAttribute('controls', 'true');
        video.play().catch(error => {
            console.log('Error al reproducir:', error);
        });
    });
    
    // 7. Si el video se pausa, mostrar botón de play nuevamente
    video.addEventListener('pause', function() {
        if (!video.ended) {
            playButton.style.display = 'block';
            video.removeAttribute('controls');
        }
    });
    
    // 8. Prevenir acceso directo al source
    video.addEventListener('loadstart', function() {
        // Protección adicional
    });
    
    // 9. Prevenir la descarga mediante inspección de elementos
    // (Aunque esto es más difícil de bloquear completamente)
}

// 10. Protección adicional contra la descarga
window.addEventListener('keydown', function(e) {
    // Bloquear F12, Ctrl+Shift+I, Ctrl+U, etc.
    if (e.keyCode === 123 || // F12
        (e.ctrlKey && e.shiftKey && e.keyCode === 73) || // Ctrl+Shift+I
        (e.ctrlKey && e.keyCode === 85)) { // Ctrl+U
        e.preventDefault();
        return false;
    }
});

///Permite rastreo de avance de cada video aue el usuario ha visto:
function saveVideoProgress(videoElement) {
   // Obtener el ID del video desde el atributo data-idvideo
   const videoId = videoElement.getAttribute('data-idvideo');
   
   // Calcular el progreso en porcentaje
   const progress = (videoElement.currentTime / videoElement.duration) * 100;
   
   // Verificar que tenemos datos válidos
   if (!videoId || isNaN(progress)) {
       console.error('No se puede guardar el progreso: datos inválidos');
       return;
   }
   
   // Preparar los datos a enviar
   const progressData = {
       video_id: videoId,
       progress: Math.round(progress * 100) / 100, // Redondear a 2 decimales
       current_time: videoElement.currentTime,
       duration: videoElement.duration
   };
   
   // Enviar al backend PHP
   fetch('save_progress.php', {
       method: 'POST',
       headers: {
           'Content-Type': 'application/json'
       },
       body: JSON.stringify(progressData)
   })
   .then(response => {
       if (!response.ok) {
           throw new Error('Error en la respuesta del servidor');
       }
       return response.json();
   })
   .then(data => {
       console.log('Progreso guardado exitosamente:', data);
   })
   .catch(error => {
       console.error('Error al guardar progreso:', error);
   });
}

// Función para inicializar el seguimiento automático
function initVideoProgressTracking() {
   const video = document.querySelector('video[data-idvideo]');
   
   if (!video) {
       console.error('No se encontró video con data-idvideo');
       return;
   }
   
   let saveTimeout;
   
   // Guardar progreso cada vez que el tiempo cambia (con debounce)
   video.addEventListener('timeupdate', function() {
       clearTimeout(saveTimeout);
       saveTimeout = setTimeout(() => {
           saveVideoProgress(this);
       }, 2000); // Esperar 2 segundos antes de guardar
   });
   
   // Guardar inmediatamente cuando termina el video
   video.addEventListener('ended', function() {
       saveVideoProgress(this);
   });
   
   // Guardar cuando el usuario pausa
   video.addEventListener('pause', function() {
       saveVideoProgress(this);
   });
}
function closeCuativo(){
    document.getElementById('cautivo').style.display = "none";
}