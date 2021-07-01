
<p align="center"><img src="https://raw.githubusercontent.com/JamesTovarR04/soft-usco/f7043c2fd32051dd3986ded3991cc0cb1ebba333/public/images/svg/Imagotipo-Hrz-Software.svg" width="300"></p>
## Acerca de Software USCO
Software usco es una plataforma digital para los programas de pregrado de **ingeniería de software** y **tecnología en desarrollo de software** de la <a href="https://www.usco.edu.co/es/" target="_blank">Universidad Surcolombiana</a> a cual tiene como objetivo brindar la mayor información posible respecto a estos programas.
## Instalar y correr (Local)
### Requerido
- **PHP** [*^7.3.0* ]
- **MySQL** [*^8.0 *]
- **Composer**
- **Git**

### Instalar

#### Clonar el Repositorio de git

`git clone https://github.com/JamesTovarR04/soft-usco.git`

- Moverse a la carpeta del proyecto:

`cd soft-usco`

#### Descargar las dependencias

`composer install`

#### Configurar Entorno
La configuración del entorno se hace en el archivo .env pero esé archivo no se puede versionar según las restricciones del archivo .gitignore, igualmente en el proyecto hay un archivo de ejemplo .env.example debemos copiarlo con el siguiente comando:

`cp .env.example .env`

Luego es necesario modificar los valores de las variables de entorno para adecuar la configuración a nuestro entorno de desarrollo, por ejemplo los parámetros de **conexión a la base de datos**.
Para que funciona el sistema de login debe crear y configurar un proyecto en google cloud platform con una cuenta de google vinculada a la universidad para obtener las credenciales para cliente OAuth 2.0 e ingresarlas en las variables de entorno:
   ```shell
GOOGLE_CLIENT_ID=
GOOGLE_CLIENT_SECRET=
```
#### Generar Clave de Seguridad de la Aplicación

`php artisan key:generate`

#### Migrar la Base de Datos

El proyecto ya tiene los modelos y migraciones generados. Entonces lo único que nos hace falta es ejecutar la migración y ejecutar el siguiente comando:

`php artisan migrate:fresh`

#### Correr
Una vez configurada la aplicación, puede iniciar el servidor de desarrollo **local** de Laravel utilizando el comando serve de Artisan CLI:

`php artisan serve`

## Contribuir al desarrollo

Para contribuir al desarrollo del proyecto debes pertenecer a la **comunidad estudiantil de la Universidad Surcolombiana**, haga un fork del repositorio y desarrolla siguiendo la [guia de desarrollo](https://github.com/JamesTovarR04/soft-usco/blob/develop/DEVELOP.md "guia de desarrollo").

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/JamesTovarR04/soft-usco/develop/public/images/readme/laravel.jpg"></a><a href="https://es.reactjs.org/" target="_blank"> <img src="https://raw.githubusercontent.com/JamesTovarR04/soft-usco/develop/public/images/readme/react.jpg"></a></p>
Por el momento se esta usando el framework **Laravel 8 **para el desarrollo del back-end y la librería de **react js** para el front-end.
