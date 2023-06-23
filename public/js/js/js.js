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

const btnToggle = document.querySelector('.btn-toggle');

btnToggle.addEventListener('click', () => {

    const body = document.body;

    if(body.classList.contains('dark')){

        body.classList.add('light')
        body.classList.remove('dark')
        btnToggle.innerHTML = 'Go dark'

    } else if (body.classList.contains('light')) {

        body.classList.add('dark')       
        body.classList.remove('light')
        btnToggle.innerHTML = 'Go Light'

    }
}
);

// modal inscription
const modalContainer = document.querySelector(".modal-container");
const modalTriggers = document.querySelectorAll(".modal-trigger");

modalTriggers.forEach(trigger => trigger.addEventListener("click", toggleModal));

function toggleModal() {
    modalContainer.classList.toggle("active")
};

