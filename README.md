# tchat-vuejs-mercure

## Setup

* `wget https://github.com/dunglas/mercure/releases/download/v0.5.0/mercure_0.5.0_Linux_x86_64.tar.gz`  
* `tar -zxvf mercure_0.5.0_Linux_x86_64.tar.gz` mercure

* `cd tchat-client && npm install`
* `cd server && composer install`

* Api server `symfony server:start --no-tls`  
* Mercure server `cd mercure && JWT_KEY='aVerySecretKey' ADDR='0.0.0.0:3000' ALLOW_ANONYMOUS=1 CORS_ALLOWED_ORIGINS=192.168.0.40
,127.0.0.1 ./mercure`  
* Vue client `npm run serve`  

## Tools

* Listener `node Listener/app.js`
