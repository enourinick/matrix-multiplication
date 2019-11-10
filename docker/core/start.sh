#!/usr/bin/env bash

chown www-data /var/www/bootstrap/cache
chown -R www-data /var/www/storage
chmod -R uog+rw /var/www/bootstrap/cache
chmod -R uog+rw /var/www/storage

service inetutils-syslogd restart

service nginx stop
service nginx start

php-fpm&

${INSTALL_DIR:=/var/www}

# Check composer
if [[ ! -d ${INSTALL_DIR}/vendor ]]; then
  # No vendor folder, run composer install
  composer install --no-scripts --no-progress --no-suggest -d ${INSTALL_DIR}
fi

# Check the database connection
while php ${INSTALL_DIR}/artisan migrate:status | grep -q 'Connection refused'
do
 echo 'Waiting for database container getting up'
 sleep 1s
done

# Run the log migration
php ${INSTALL_DIR}/artisan migrate

tail -f /var/log/messages
