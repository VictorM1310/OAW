# OAW

## Pasos de instalación

1. Instalar [Composer](https://getcomposer.org/download/)

2. Mover el proyecto dentro de la carpeta de htdocs de Apache. Recomiento que poner el proyecto dentro de una carpeta llamada **_oaw_**. (**_C:\xampp\htdocs\oaw_**)

3. Modificar el archivo **_.env_** con las credenciales de tu db.

4. Correr el comando **_composer install_** en la carpeta raíz del proyecto.

5. Correr el comando **_vendor/bin/doctrine orm:schema-tool:update --force_** en la raíz del proyecto. Asegúrate de tener el MySQL corriendo y una base de datos con el mismo nombre especificado en el archivo **_.env_**.

6. Para probar, realizar un petición **GET** al archivo **_add_or_get_rss_feed.php_** y pasar como _query param_ el url del _RSS Feed_. **_(http://localhost/oaw/app/add_or_get_rss_feed.php?url=https://expansion.mx/rss/carrera)_**

## Hacer peticiones desde Ajax

Utilizar el siguiente snippet como referencia para hacer peticiones Ajax.

```js
const fetchFeed = () => {
  fetch('./../app/get_all_rss_feeds.php')
    .then((data) => data.json())
    .then((result) => console.log(result));
};
```
