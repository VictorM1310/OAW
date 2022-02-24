//Variables
const body = document.querySelector("body"),
sidebar = body.querySelector(".sidebar"),
toggle = body.querySelector(".toggle"),
searchBtn = body.querySelector(".search-box"),
modeSwtich = body.querySelector(".toggle-switch"),
modeText = body.querySelector(".mode-text");
//Usando un método para manipular el cierre del menu
toggle.addEventListener("click",()=>{
    sidebar.classList.toggle("close");
});
//Si se tiene cerrado el menu y se le da click 
//al simbolo de buscar se abre el menu
searchBtn.addEventListener("click",()=>{
    sidebar.classList.remove("close");
});
//Usando método para cambiar el modo de la página.
//Dependiendo del modo se verá el menu
modeSwtich.addEventListener("click",()=>{
    body.classList.toggle("dark");
    body.classList.contains("dark") ? modeText.innerText = "Light Mode" : modeText.innerText = "Dark Mode";
});
