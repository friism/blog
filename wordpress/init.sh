#! /bin/sh

wp config create --skip-check --dbname=db --dbuser=wordpress --dbpass=$DB_PASS --dbhost=db --extra-php <<PHP
define( 'WPCOM_API_KEY', '$WP_API_KEY' );
PHP

until wp db check; do
    sleep 1;
done

wp core install --url=$WP_URL --title=$WP_TITLE --admin_user=$WP_ADMIN_USER --admin_password=$WP_ADMIN_PASSWORD --admin_email=$WP_ADMIN_EMAIL --skip-email

wp plugin delete hello
wp plugin install akismet wordpress-importer
wp plugin update akismet
wp plugin activate akismet

wp option set permalink_structure "/%postname%/"

wp theme install wp-bootstrap-starter --activate
wp theme activate wp-bootstrap-starter-child
wp widget deactivate categories-2 meta-2 recent-posts-2 recent-comments-2

wp menu create "Navigation"
wp menu location assign Navigation primary

wp theme delete twentyfifteen twentyseventeen twentysixteen

wp post delete $(wp post list --post_type='page,post' --format=ids)
