FROM php:7.3-fpm

# Fix debconf warnings upon build
ARG DEBIAN_FRONTEND=noninteractive

ARG APP_USER=www
RUN groupadd -r ${APP_USER} && useradd --no-log-init -r -g ${APP_USER} ${APP_USER}

# Set working directory
WORKDIR /var/www

# Copy composer.lock and composer.json
#COPY ./composer.lock ./composer.json /var/www/

# Install selected extensions and other stuff
RUN apt-get update \
    && apt-get -y --no-install-recommends install  php7.3-mysql php-xdebug php7.3-gd php-imagick \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

# Install git
RUN apt-get update \
    && apt-get -y install git \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*


# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
        default-mysql-client \
        libpng-dev \
        libjpeg62-turbo-dev \
        libfreetype6-dev \
        locales \
        zip \
        jpegoptim optipng pngquant gifsicle \
        vim \
        unzip \
        git \
        curl

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*


# Install extensions
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl
RUN docker-php-ext-configure gd --with-gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ --with-png-dir=/usr/include/
RUN docker-php-ext-install gd

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer




# Add user for laravel application
#RUN groupadd -g 1000 ${APP_USER}
#RUN useradd -u 1000 -ms /bin/bash -g ${APP_USER} ${APP_USER}

# Copy existing application directory contents
COPY . /var/www

# Copy existing application directory permissions
COPY --chown=${APP_USER}:${APP_USER} ./ /var/www

# Change current user to www
#USER ${APP_USER}


RUN pwd
RUN ls
COPY .env.example .env
RUN "composer install"
RUN npm install

RUN php artisan key:generate
RUN php artisan migrate --seed

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]
