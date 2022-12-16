docker-compose up -d &&
docker container exec eduardo-jn2-teste-composer "cd /app && composer install" -g
docker container exec eduardo-jn2-teste-composer "cd /var/www/html && php artisan migrate" -g


