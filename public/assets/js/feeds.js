const fetchFeeds = () => {
    fetch("./../app/get_all_rss_feeds.php")
    .then((data) => data.json())
    .then((result) => {
        for (let i = 0; i < result.length; i ++){
            
            insertaCajasFeed(result[i].title, result[i].description,i);
        }
    });
};

function insertaCajasFeed(title, description, i){
    let caja = `
    <div class="col-md-6 mt-2 ps-3 pe-3">
        <div class="card text-dark bg-light mb-3 text-center rounded-bottom" style="border:none">
            <div class="card-header text-white rounded-top" style="background:#246180 outline:none">
                ${title}
            </div>
            <div class="card-body">
                <p class="card-text">${description}</p>
                <a onclick="cargarId(${i})" class="btn btn-outline-dark" href="news.html">Check this feed</a>
            </div>
        </div>
    </div>`
    const idRow = document.getElementById('row');
    idRow.insertAdjacentHTML('beforeend', caja);
}

function cargarId(Id){
    sessionStorage.setItem('id', Id);
}

fetchFeeds();

var formulario = document.getElementById('formulario');

var url;
var datos
formulario.addEventListener('submit', function(e){
    e.preventDefault();
    datos = new FormData(formulario);
    url = datos.get('url')
    fetch(`./../app/add_or_get_rss_feed.php?url=${url}`)
    .then(res => res.json())
    .then(data =>{
    setInterval("location.reload()",100);
});
    
})




