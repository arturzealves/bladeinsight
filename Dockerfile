FROM php:7.4-fpm

# RUN apt-get update && apt-get install -y \
#     vim \
#     unzip \
#     git

## Install Composer
COPY --from=composer /usr/bin/composer /usr/bin/composer

# RUN chmod -R 777 /var/www/html/
RUN chown -R www-data:www-data /var/www/html
COPY composer.json composer.lock ./
# RUN composer install

WORKDIR /var/www/html
CMD ["php-fpm"]
USER www-data

###
# I could not make this docker image able to run 'composer install' because
# there was an error related with permissions on the 'vendor' folder.
# So to make this image able to run unit tests, we need to first run 
# 'composer install' on the host machine, then run 'make dev' and finally 
# 'make test'.
##
