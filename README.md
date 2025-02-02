# Project Overview and instructions

This application is designed for event management. Anyone can register using their email. From the admin dashboard, users can add, edit, delete, and view events with specific details. They can manually register attendees from the panel, view the attendee list, and download a CSV file of all attendees.

All events are visible to guest users. They can register for an event if it is active within the specified timeframe and has available attendee capacity and also view all available events on the homepage.

Both the event list and attendee list are searchable and sortable.

# Application Link: 
    http://63.142.255.105
# Login Credentials:
    Email: raqibhasan.2120@gmail.com
    Password: 12345678

# Tools and Technologies

This project is built using pure PHP, JavaScript, and MySQL.

# Minimum requirement

PHP 8.2

# Installation instruction

1. At first copy `.env.example` and rename it to `.env`. Configure with you BASE_URL and DB credentials
2. Then, run `composer install`
3. Then, run `php run-migration.php`

# JSON API end point to fetch event details

    endpoint: /api/events/{eventId}
    method: GET
    successful response example: {
        "message": "Event details for event id: 4",
        "data": {
            "event": {
                "id": 4,
                "name": "Tournament Registration",
                "description": "We will organize a cricket tournament, Please register now.",
                "max_capacity": 20,
                "start_time": "2025-01-29 01:37:00",
                "end_time": "2025-02-13 20:25:00",
                "created_by": 2,
                "created_at": "2025-02-01 20:20:02",
                "updated_at": "2025-02-02 01:42:11"
            },
            "totalAttendees": 2
        }
    }
    error response example: {
        "message": "Event details for event id: 4",
        "data": {
            "message": "Event not found",
            "statusCode": 404,
            "errors": []
        }
    }

# Local nginx config to run this project

    server {
        listen 80;
        server_name myproject.event-management.local; # change it based on your project setup

        root /var/www/projects/event_management; # change it based on you file structure
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
    
# Local apache2 config to run this project
    Just clone it to your project repository 
