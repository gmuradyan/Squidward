# Squidward
Employee matching tool

Inital set up
1. git clone repo
2. cd laradock
3. cp .env.example .env
4. Make shure you hev installed docker/ docker-compose

Up server
1. docker-compose up -d ngnix
2. docker-compose exec workspace bash
3. php artisan serve

Open http://localhost


For code review start from - /server/routes/api.php