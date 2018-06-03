# Run Wordpress in Docker

Source code for running my Wordpress powered blog in Docker containers

## Architecture

Three containers:

* MariaDB
* nginx
* FPM/Wordpress

FPM/Wordpress and nginx container shares a folder with all the Wordpress files. Any static files and Wordpress media files are served by nginx directly.

nginx container forwards requests for `.php` files to the FPM/Wordpress container on TCP port 9000 using the FastCGI protocol.

Wordpress uses MariaDB (over TCP) for persistense of posts. Media is persisted on the Docker volume that nginx and Wordpress shares.

## How to Use

### Development

TODO

### Production

1. Create volumes for Wordpress and MariaDB data.

    docker volume create blog-db-data
    docker volume create blog-www-html

2. Build

    docker-compose -f .\docker-compose.prod.yml build

3. Set passwords as env vars. These are substituted by Docker Compose (example is for PowerShell).

    $env:DB_PASS="YOURDBPASSWORD"
    $env:WP_ADMIN_PASSWORD="YOURWPPASSWORD"

4. Initialize Wordpress. Use whatever URL is correct for your blog. API keys can be had from [Akismet](https://akismet.com/).

    docker-compose -f .\docker-compose.prod.yml run -e WP_API_KEY=YOUR_API_KEY -e WP_URL=localhost -e WP_ADMIN_USER=YOURUSER -e DB_PASS=$env:DB_PASS -e WP_ADMIN_EMAIL=YOUREMAIL -u www-data --entrypoint=/admin/init.sh blog

5. Start the whole edifice

