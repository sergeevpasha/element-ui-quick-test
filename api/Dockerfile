FROM php:8.2-cli

ARG UNAME=admin
ARG UGROUP=admin
ARG UID=1000
ARG GID=1000

RUN groupadd -g $GID $UGROUP && \
    useradd -u $UID -g $UGROUP -ms /bin/bash $UNAME && \
    usermod -aG sudo $UNAME

RUN apt-get update && apt-get install -y --no-install-recommends \
    curl \
    cron \
    zip \
    unzip \
    libpq-dev \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN docker-php-ext-install pdo_pgsql

RUN echo "* * * * * www-data php /var/www/artisan schedule:run >> /dev/null 2>&1" > /etc/cron.d/laravel \
    && chmod 0644 /etc/cron.d/laravel \
    && crontab /etc/cron.d/laravel

EXPOSE 8000

WORKDIR /var/www
