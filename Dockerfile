# Use the official PHP image with Apache
FROM php:8.1-apache

# Copy your PHP files to the /var/www/html/ directory in the container
COPY accessToken.php /var/www/html/
COPY batteryNotification.php /var/www/html/
COPY your-service-account-file.json /var/www/html/

# Set working directory
WORKDIR /var/www/html/

# Expose port 80 to be able to access the application
EXPOSE 80

# Start the Apache server
CMD ["apache2-foreground"]
