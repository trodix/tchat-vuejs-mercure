# tchat-vuejs-mercure

## Setup

### Download Mercure server

* `wget https://github.com/dunglas/mercure/releases/download/v0.5.0/mercure_0.5.0_Linux_x86_64.tar.gz`  

### Extract Mercure server archive

* `tar -zxvf mercure_0.5.0_Linux_x86_64.tar.gz mercure`

### Install node_modules

* `cd tchat-client && npm install`

### Install php dependencies

* `cd server && composer install`

### Run Api server

* Api server `symfony server:start --no-tls`  or `php -S 0.0.0.0:8000 -t public/`

### Run Mercure server

* Mercure server `cd mercure && JWT_KEY='aVerySecretKey' ADDR='0.0.0.0:3000' ALLOW_ANONYMOUS=1 CORS_ALLOWED_ORIGINS=* ./mercure`  

### Run vuejs client as dev

* Vue client `npm run serve`  

## Tools

* Listener (client listening on topic) `node Listener/app.js`

## Config files

### Api server

#### TchatController:updatetchat()

* topic to send data
  
``` php
$topic = "http://192.168.0.40:8000/tchat";
```

#### .env

``` yaml
MERCURE_PUBLISH_URL=http://192.168.0.44:3000/hub
MERCURE_SUBSCRIBE_URL=http://192.168.0.44:3000/hub
```

### vuejs client

#### App.vue

``` javascript
const hub_url = 'http://192.168.0.44:3000/hub';
const api_url = 'http://192.168.0.40:8000/tchat';
const topic   = 'http://192.168.0.40:8000/tchat';
```
