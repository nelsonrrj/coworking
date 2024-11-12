# Proyecto coworking

Este es un proyecto de ejemplo utilizando Laravel 11. Sigue las instrucciones a continuación para configurar y ejecutar el proyecto en tu entorno local utilizando Docker.

## Requisitos

-   Docker
-   Docker Compose

## Instalación

1. Clona este repositorio:

    ```sh
    git clone git@github.com:nelsonrrj/coworking.git
    cd coworking
    ```

2. Copia el archivo de entorno y configura las variables necesarias:

    ```sh
    cp .env.example .env
    ```

3. Construye las imagenes de Docker:

    ```sh
    docker-compose build
    docker-compose up server -d
    ```

4. Instala las dependencias de Composer y genera la clave de la aplicación:

    ```sh
    docker-compose run composer install
    docker-compose run artisan key:generate
    ```

5. Ejecuta las migraciones para preparar la base de datos:

    ```sh
    docker-compose run artisan migrate
    ```

## Ejecutar el Proyecto

1. Asegúrate de que los contenedores de Docker están en funcionamiento:

    ```sh
    docker-compose up server -d
    ```

2. Accede a la aplicación en tu navegador en `http://localhost:8000`.

## Ejecutar Pruebas

1. Para ejecutar las pruebas, usa el siguiente comando:

    ```sh
    docker-compose up server -d
    docker-compose run artisan test
    ```

    Este comando ejecutará todas las pruebas definidas en el directorio `tests` de tu aplicación Laravel.
