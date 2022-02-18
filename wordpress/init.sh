#! /bin/sh

wp config create --skip-check --dbname=db --dbuser=wordpress --dbpass=$DB_PASS --dbhost=db --extra-php <<PHP
define( 'WPCOM_API_KEY', '$WP_API_KEY' );
PHP

until wp db check; do
    sleep 1;
done

wp core install --url=$WP_URL --title=$WP_TITLE --admin_user=$WP_ADMIN_USER \
    --admin_password=$WP_ADMIN_PASSWORD --admin_email=$WP_ADMIN_EMAIL --skip-email \
    --skip-themes

wp plugin install akismet --activate
wp plugin update akismet
wp plugin activate akismet

wp option set permalink_structure "/%postname%/"
wp option update blogdescription "$WP_DESCRIPTION"

wp theme activate friism
