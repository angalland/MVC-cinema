// Detecte si le dark mode est activer
// if(window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches){
//     // si il est activer on peut rajouter des icons, des animation ect..
//     alert ("Vous êtes en dark mode !");
// }

function themeNuitJour(){
    const date = new Date()
    const hour = date.getHours()

    if (hour < 5 || hour > 20) {
        document.documentElement.style.setProperty('--ecritureBody', 'black')
        document.documentElement.style.setProperty('--ecritureDiv', 'white')
        document.documentElement.style.setProperty('--fondBody', 'white')
        document.documentElement.style.setProperty('--fondDiv', '#333')

    } else {
        document.documentElement.style.setProperty('--ecritureBody', 'white')
        document.documentElement.style.setProperty('--ecritureDiv', 'black')
        document.documentElement.style.setProperty('--fondBody', '#333')
        document.documentElement.style.setProperty('--fondDiv', 'white')
    }
}

themeNuitJour()