let id = sessionStorage.getItem('id');

const fetchFeeds = () => {
    fetch("./../app/get_all_rss_feeds.php")
    .then((data) => data.json())
    .then((result) => {
        for (let j = 0; j < result[id].news.length; j++){
             insertarCajasNews(result[id].news[j].title, result[id].news[j].description, result[id].news[j].categories,result[id].news[j].pubDate, result[id].news[j].url);
        }
    });
};

function refresh(){
    limpiar();
    fetch(`./../app/update_rss_feeds.php?selected_rss=${String(parseInt(id)+1)}`)
    .then((data) => data.json())
    .then((result) => {
        for (let j = 0; j < result.news.length; j++){
             insertarCajasNews(result.news[j].title, result.news[j].description, result.news[j].categories,result.news[j].pubDate, result.news[j].url);
        }
    });
}

fetchFeeds();

function insertarCajasNews(title, description, categories,pubDate,url){
    let cajaNews = `
    <div class="col-md-6 mt-2 ps-3 pe-3">
        <div class="card text-dark bg-light mb-3 text-center rounded-bottom" style="border:none">
            <div class="card-header text-white rounded-top" style="background:#246180 outline:none">
                ${title}
            </div>
            <div class="card-body">
                <p class="card-text" style="overflow:hidden">${description} </p>
                <p class="card-text">${categories}</p>
                <footer><p class="card-text mb-3">${pubDate.date}</p></footer>
                <a class="btn btn-outline-dark" href="${url}">Check the entire news</a>
            </div>
        </div>
    </div>`
    const rowNews = document.getElementById('news');
    rowNews.insertAdjacentHTML('beforeend', cajaNews);
}

function limpiar(){
    let div = document.getElementById('news');
    div.innerHTML="";
}
function obtenerCampo(){
    let lista = document.order.orderSelect;
    let elegido = lista.selectedIndex;
    let opcion = lista.options[elegido];
    let field = opcion.text
    

    ordenar(field)

}

function ordenar(field){
    let lista = document.orientation.orientationSelect;
    let elegido = lista.selectedIndex;
    let opcion = lista.options[elegido];
    let order = opcion.text;

    if(order == "ascendant"){
        order = "asc"
    }else {
        order = "desc"
    }

    limpiar();
    fetch(`./../app/get_news_ordered_by.php?id=${String(parseInt(id)+1)}&field=${field}&sort_order=${order}`)
    .then((data) => data.json())
    .then((result) => {
        for(let i = 0; i < result.length; i++){
            insertarCajasNews(result[i].title, result[i].description,result[i].categories,result[i].pubDate,result[i].url)
        }
    });
}

function search(){

    let form = document.getElementById('formulario');
    let datos = new FormData(formulario);
    let title = datos.get('search');
    limpiar()
    fetch(`./../app/search_rss_news_by_title.php?id=${String(parseInt(id)+1)}&title=${title}`)
    .then((data) => data.json())
    .then((result) => {
         for(let i = 0; i < result.length; i++){
             insertarCajasNews(result[i].title, result[i].description,result[i].categories,result[i].pubDate,result[i].url)
         }
     });
}

