#! /bin/sh

wp config create --skip-check --dbname=db --dbuser=wordpress --dbpass=Passw0rd --dbhost=db --extra-php <<PHP
define( 'WPCOM_API_KEY', '$WP_API_KEY' );
PHP

wp core install --url=$WP_URL --title=Randoom --admin_user=$WP_ADMIN_USER --admin_password=$WP_ADMIN_PASSWORD --admin_email=$WP_ADMIN_EMAIL --skip-email

wp plugin delete hello
wp plugin install akismet
wp plugin update akismet
wp plugin activate akismet

wp option set permalink_structure "/%postname%/"
wp theme install wp-bootstrap-starter --activate
wp theme delete twentyfifteen twentyseventeen twentysixteen
