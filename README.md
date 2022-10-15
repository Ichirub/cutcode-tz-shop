# Installation

- ```php artisan storage:link```
- ```composer install```
- ```php artisan migrate```

# DOCKER Installation

- ```docker-compose build app```
- ```docker-compose up -d```
- ```docker-compose exec app composer install```
- ```docker-compose run --rm npm install```
- ```docker-compose exec app php artisan cache:clear```
- ```docker-compose exec app php artisan config:clear```

# DOCKER Npm

- ```docker-compose run --rm npm install {PACKAGE_NAME}```
- ```docker-compose run --rm npm run dev```
- ```docker-compose run --rm npm run build```

# Deploy

