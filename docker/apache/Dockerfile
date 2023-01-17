FROM php:7.4-apache
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf
RUN apt-get update
RUN apt-get -y upgrade
RUN apt-get install -y --no-install-recommends \
    libpng-dev \
    libmcrypt-dev \ 
    libicu-dev \
    zlib1g-dev \
    libpq-dev \
    libzip-dev \
    libpcre3-dev \
    zlib1g-dev \
    ssmtp vim git cron zip \
    nano

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN chmod +x /usr/local/bin/install-php-extensions && \
    install-php-extensions pdo_pgsql pgsql

RUN docker-php-ext-install \
    intl \
    pdo \
    pdo_pgsql \
    pgsql \
    zip

# 2. setingan document root untuk apache
COPY docker/apache/000-default.conf /etc/apache2/sites-available/000-default.conf

# 3. mod_rewrite untuk URL rewrite and mod_headers untuk .htaccess extra headers --> Access-Control-Allow-Origin-
RUN a2enmod rewrite headers

# 4. start with base php config, kemudian add extensions
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

# 5. install composer
#RUN curl -sS https://getcomposer.org/installer | php
#RUN mv composer.phar /usr/local/bin/composer
#RUN chmod +x /usr/local/bin/composer
#RUN composer self-update

# COPY src/ /var/www/html/
# 6. butuh pengguna yang sama dengan UID/GID dengan host user
ARG uid
RUN useradd -G www-data,root -u $uid -d /home/devuser devuser
RUN mkdir -p /home/devuser/.composer && \
    chown -R devuser:devuser /home/devuser

# open permission 
RUN chmod 777 ./ -R

# # create codeigniter 4
# # RUN composer create-project codeigniter4/appstarter ./
# RUN mkdir /root/.ssh/
# COPY ./root/ssh-docker /root/.ssh/ssh-docker

# # Create known_hosts
# RUN touch /root/.ssh/known_hosts
# # Add bitbuckets key
# RUN ssh-keyscan github.com >> /root/.ssh/known_hosts

# RUN git clone -b fikri git@github.com:nougatlolipop/umsu-academy.git

# RUN composer install

# # volume folder
# VOLUME ./app:/var/www/html

# # RUN permission
#RUN chmod 777 -R /var/www/html/writable

# # RUN environmenrt
# RUN cp env .env

# EXPOSE port
EXPOSE 80
