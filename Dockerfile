FROM php:8.1.0alpha3-apache

RUN docker-php-ext-install pdo_mysql

RUN a2enmod rewrite
