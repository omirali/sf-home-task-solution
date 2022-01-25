FROM wyveo/nginx-php-fpm:php74

ARG ROOT_PATH=/var/www/html/project-app
ARG STORAGE_PATH=storage
ARG WEB_USER=nginx
ARG WEB_GROUP=nginx
ARG PHP_INI=/etc/php/7.4/fpm/php.ini

COPY . ${ROOT_PATH}
COPY .config/php/php.ini ${PHP_INI}
COPY .config/nginx/conf.d/* /etc/nginx/conf.d/
COPY .config/supervisord.conf /etc/supervisord.conf

RUN chown -R ${WEB_USER}:${WEB_GROUP} ${ROOT_PATH}/public

WORKDIR ${ROOT_PATH}
RUN cd ${ROOT_PATH} && composer self-update --2 && composer install