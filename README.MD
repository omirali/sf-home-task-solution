Solution of test tasks. https://github.com/sunfinancegroup/docs-home-task-hh
##Start application
````
docker-compose up --build
````
Run the following command from the ``nginx-php74`` container
````
php bin/console doctrine:migrations:migrate --no-interaction
````