# OAW

## Pasos de instalación

> Se requiere PHP 8.0.1 o superior para evitar problemas.

1. Instalar [Composer](https://getcomposer.org/download/)

2. Mover el proyecto dentro de la carpeta de htdocs de Apache. Recomiento que poner el proyecto dentro de una carpeta llamada **_oaw_**. (**_C:\xampp\htdocs\oaw_**)

3. Modificar el archivo **_.env_** con las credenciales de tu db.

4. Correr el comando **_composer install_** en la carpeta raíz del proyecto.

5. Correr el comando **_vendor/bin/doctrine orm:schema-tool:update --force_** en la raíz del proyecto. Asegúrate de tener el MySQL corriendo y una base de datos con el mismo nombre especificado en el archivo **_.env_**.

6. Para probar, realizar un petición **GET** al archivo **_add_or_get_rss_feed.php_** y pasar como _query param_ el url del _RSS Feed_. **_(http://localhost/oaw/app/add_or_get_rss_feed.php?url=https://expansion.mx/rss/carrera)_**

## Funcionamiento

- Los servicios que provee el back se usan haciendo fetch a los 4 archivos que están en la carpeta **_app_**.

### [GET] add_or_get_rss_feed.php

Se agrega o se obtiene las noticias de un nuevo feed pasando como parámetro una URL.

Ejemplo:

```
http://localhost/oaw/app/add_or_get_rss_feed.php?url=https://expansion.mx/rss/carrera
```

### [GET] get_all_rss_feeds.php

Devuelve un array con todos los feeds agregados y, por el momento, las respectivas noticias de cada Feed. Esta función esta pensada para rellenar un **_select_** de los RSS Feeds en el frontend. Por ahora, retorna todas las Feeds con TODAS las noticias, proponemos dejarlo así con el fin de poner números más interesantes en el reporte de VH.

### [GET] get_news_ordered_by.php

Devuelve las noticias de un feed específico ordenando de manera ascendente o descendente por campo. Los **_query params_** ha utilizar son: **_id_**, **_field_** y **_sort_order_**

Ejemplo:

```
http://localhost/oaw/app/get_news_ordered_by.php?id=1&field=title&sort_order=desc
```

### [GET] search_rss_by_title.php

Obtiene las noticias de un feed específico filtrando por título.

Ejemplo:

```
http://localhost/oaw/app/search_rss_news_by_title.php?id=2&title=ucrania
```

El backend esta hecho con la idea de que siempre haya un feed "seleccionado", por eso **_get_news_ordered_by.php_** y **_search_rss_news_by_title.php_** necesitan el id de un feed para recuperar la información.

## Hacer peticiones desde Ajax

Utilizar el siguiente snippet como referencia para hacer peticiones Ajax.

```js
const fetchFeeds = () => {
  fetch('./../app/get_all_rss_feeds.php')
    .then((data) => data.json())
    .then((result) => console.log(result));
};
```
