FROM php:8.2-fpm
LABEL maintainner='taufik123'

# Set working directory to /var/www
WORKDIR /var/www/html/laravel

# COPY entrypoint.sh /usr/local/bin/
# RUN chmod +x /usr/local/bin/entrypoint.sh
# ENTRYPOINT ["entrypoint.sh"]

# Copy Nginx configuration file
COPY .docker/nginx.conf /etc/nginx/
COPY .docker/nginx-laravel.conf /etc/nginx/sites-available/
RUN mkdir /etc/nginx/sites-enabled
RUN ln -s /etc/nginx/sites-available/nginx-laravel.conf /etc/nginx/sites-enabled/

# ARG user=nobody
# ARG uid=999

ARG user
ARG uid

RUN apt update && apt install -y nano\
    git \
    curl \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libzip-dev \
    zip \
    unzip 

# Install PHP extensions
RUN docker-php-ext-install -j$(nproc) pdo_mysql zip pcntl bcmath gd && docker-php-ext-configure gd --with-freetype --with-jpeg && docker-php-ext-install -j$(nproc) gd && docker-php-ext-install mysqli

# Change current user to nobody
# RUN usermod -u $uid $user && groupmod -g $gid $user || :
# RUN if [ $? -ne 0 ]; then usermod -u $uid $user; fi

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

USER $user


# Install Composer
COPY --from=composer:2.4.3 /usr/bin/composer /usr/local/bin/composer

# Copy current application directory contents into the container at /var/www
COPY . /var/www/html/laravel

# Install project dependencies
RUN composer install --no-interaction
# RUN npm install
# VOLUME /var/www/html
# RUN chmod -R 755 /var/www/html/laravel && chmod -R 777 /var/www/html/laravel/storage
# RUN chown www-data:www-data /var/www/html/laravel/storage
# RUN php artisan key:generate
RUN php artisan cache:clear
RUN php artisan config:cache

# Expose port 9000 and start php-fpm server
# EXPOSE 80
# CMD ["php-fpm"]