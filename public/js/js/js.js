// Detecte si le dark mode est activer
// if(window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches){
//     // si il est activer on peut rajouter des icons, des animation ect..
//     alert ("Vous êtes en dark mode !");
// }

// fonction qui modifie les variables css celon les horaires de la journee
// function themeNuitJour(){
//     const date = new Date()
//     const hour = date.getHours()

//     if (hour > 5 || hour < 20) {
//         document.documentElement.style.setProperty('--ecritureBody', 'black')
//         document.documentElement.style.setProperty('--ecritureDiv', 'white')
//         document.documentElement.style.setProperty('--fondBody', 'white')
//         document.documentElement.style.setProperty('--fondDiv', '#333')

//     } else {
//         document.documentElement.style.setProperty('--ecritureBody', 'white')
//         document.documentElement.style.setProperty('--ecritureDiv', 'black')
//         document.documentElement.style.setProperty('--fondBody', '#333')
//         document.documentElement.style.setProperty('--fondDiv', 'white')
//     }
// }

// themeNuitJour()


// dark-mode
// selectione le bouton btnToggle
const btnToggle = document.querySelector('.btn-toggle');
// ajoute un evenment click a ce bouton
btnToggle.addEventListener('click', () => {

    const body = document.body;
    // si body a class dark, add light, remove dark
    if(body.classList.contains('dark')){

        body.classList.add('light')
        body.classList.remove('dark')
        // modifie le text du bouton
        btnToggle.innerHTML = 'Go dark'
        // sauvegarde dans le localstorage le "mode" et le "texte"
        localStorage.setItem("mode", "light")
        localStorage.setItem("text", "Go Dark")

    } else if (body.classList.contains('light')) {
    // si body a class light, add dark, remove light
        body.classList.add('dark')       
        body.classList.remove('light')
        // modifie le text du bouton
        btnToggle.innerHTML = 'Go Light'
        // sauvegarde dans le localstorage le "mode" et le "texte"
        localStorage.setItem("mode", "dark")
        localStorage.setItem("text", "Go Light")

    }
});

// sauvegarde du mode dans le localstorage
// si il y a une donnée enregistrer dans le localstorage "mode"
if (localStorage.getItem("mode") != null) {

    const body = document.body;
    const btnToggle = document.querySelector('.btn-toggle');
    // on ajoute ces donnees a la classe body et au text du bouton
    body.classList.add(localStorage.getItem('mode'))
    btnToggle.innerHTML = localStorage.getItem('text')
} else {
    // sinon prend ces valeurs par default
    body.classList.add('light')
    btnToggle.innerHTML = 'Go Dark'
}

// modal inscription
// selectionne la modal et tous les boutons de la modal
const modalContainer = document.querySelector(".modal-container");
const modalTriggers = document.querySelectorAll(".modal-trigger");
// ajoute un evenement click a tous les boutons et fait la fonction toggleModal
modalTriggers.forEach(trigger => trigger.addEventListener("click", toggleModal));
// ajoute et remove active a chaque click sur les boutons
function toggleModal() {
    modalContainer.classList.toggle("active")
};

