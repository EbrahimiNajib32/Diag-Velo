# Using a specific version of PHP with Apache
FROM php:8.2.4-apache

# Installing PHP extensions using the mlocati script
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions && \
    install-php-extensions pdo_mysql intl

# Installing Composer securely without disabling TLS
RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer

# Adding Node.js from Nodesource
RUN curl -fsSL https://deb.nodesource.com/setup_lts.x | bash - && \
    apt-get update && \
    apt-get install -y nodejs zip unzip git

# Copy the wait-for-it script
COPY wait-for-it.sh /usr/local/bin/wait-for-it.sh

# Make the script executable
RUN chmod +x /usr/local/bin/wait-for-it.sh

# Global installation of npm to ensure the latest version
RUN npm install -g npm

# Copying the application source to the container
COPY . /var/www/
COPY ./docker/apache.conf /etc/apache2/sites-available/000-default.conf

# Set ServerName to avoid Apache warning
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Ensure Apache listens on all interfaces
RUN echo "Listen 0.0.0.0:81" >> /etc/apache2/ports.conf

# Setting the working directory for following commands
WORKDIR /var/www/

# Composer install and update without running as root
RUN composer install --no-plugins --no-scripts && \
    composer update --no-plugins --no-scripts


# Exposing port 80 for the Apache server
EXPOSE 80
