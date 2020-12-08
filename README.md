## VUTTR BACKEND

WEBSERVICE VUTTR (Very Useful Tools to Remember)

## DOCUMENTAÇÃO DA API

[documentação](https://app.swaggerhub.com/apis-docs/gilgledson9/VUTTR-WEBSERVISE/1.0.0)


## INSTALAÇÃO

* Primeiramento vamos clonar o projeto
```sh 
    git clone https://github.com/gilgledson/vuttr-vue-backend
```
* acessar a pasta do projeto
```sh 
    cd vuttr-vue-backend
```
* copiar .env.example para o .env
```sh 
    cp env.example .env
```
* instalar dependencias do composer
```sh 
    composer install
```
* ajustando permissões da pasta
```sh 
    sudo chmod -R 755 storage
```
* Iniciar o container
```sh 
    docker-compose up -d --build
```
* executando migrate
```sh 
    docker exec -it vuttr_app php artisan migrate
```
* acessar api 
```sh 
    http://localhost:3000/
```
