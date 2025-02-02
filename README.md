# Project Overview and instructions

This application is designed for event management. Anyone can register using their email. From the admin dashboard, users can add, edit, delete, and view events with specific details. They can manually register attendees from the panel, view the attendee list, and download a CSV file of all attendees.

All events are visible to guest users. They can register for an event if it is active within the specified timeframe and has available attendee capacity and also view all available events on the homepage.

Both the event list and attendee list are searchable and sortable.

# Tools and Technologies

This project is built using pure PHP, JavaScript, and MySQL.

# Minimum requirement

PHP 8.2

# Installation instruction

1. At first copy `.env.example` and rename it to `.env`. Configure with you BASE_URL and DB credentials
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
