## Install
Create container
```
docker-compose up -d
```
Enter to the container
```
docker exec -it insider_test_php-fpm_1 bash
```

Install dependencies
```
composer install
```

Prepare DB
```
bin/console doctrine:database:create
bin/console doctrine:migrations:migrate
bin/console doctrine:fixtures:load
```

Application url 
http://127.0.0.1/
