# Project Overview and instructions

The application stands with event management. Where anyonne can register with their email. From the admin dashboard they can add/edit/delete/view their events with specific details.
All events are visible for guest users. They can register in any events if the event is active within timefame and have available attendee capacity. And also, view all events availbale in home page.
Logged in user can also register their attendee manually from thepanel and see the attendee list and able to download csv of all attendees.
All the event list and attendee list are searchable and sortable.

# Tools and Technologies

For this project I am using pure PHP, Javascript and Mysql

# Minimum requirement

PHP 8.2

# Installation instruction

1. At first copy `.env.example` and paste as `.env`. Setup with you BASE_URL and DB credentials
2. Then, run `composer install`
3. Then, run `php run-migration.php`

# Local nginx config to run this project

server {
listen 80;
server_name myproject.event-management.local; // change it based on your project setup

    root /var/www/projects/event_management; // change it based on you file structure
    index index.php;

    # Disable directory listing
    autoindex off;


    location / {
        rewrite ^/(.*)$ /index.php last;
        try_files $uri $uri/ /index.php?$query_string;
    }

    # Static assets (CSS, JS, images)
     location ~ ^/assets/ {
        try_files $uri =404;
    }

    location ~ ^/(doc|sql|setup)/ {
        deny all;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;  # Change this to your PHP version
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }


    location ~ /\.ht {
        deny all;
    }

}
