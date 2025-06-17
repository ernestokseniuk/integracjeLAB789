## [1] Obraz bazowy
FROM php:7.2-apache

## [2] Włączenie modułów Apache i instalacja mysqli
RUN a2enmod rewrite
RUN docker-php-ext-install mysqli

## [3] Kopiowanie plików aplikacji
COPY . /var/www/html/

## [4] Ustawienia uprawnień
RUN chown -R www-data:www-data /var/www/html/
RUN chmod -R 755 /var/www/html/

## [5] Konfiguracja Apache
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

## [6] Eksponowanie portu
EXPOSE 80

## [7] Uruchomienie Apache
CMD ["apache2-foreground"]
