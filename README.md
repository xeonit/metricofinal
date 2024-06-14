# Project Installation
## Requirements
- PHP
- composer
- POPPLER UTILS
- PHP SHELL Acceess
- MYSQL SERVER and CLIENT

### CLONING PROJECT IN YOUR SERVER ROOT
1. Clone Project in your server root directory.
2. Make sure to use right permissions so laravel can work properly. In my development server I had to use ```sudo chmod o+w -R <your-directory>``` to make things work.


### INSTALLING DEPENDENCIES
1. Navigate to your root directory. 
2. Use ```composer update``` to install every dependencies

### SETTING UP DATA BASE
There are two ways to setup database. First one via artisan command.
To do that you have to put mysql client binary (MYSQL_CLIENT) path in .env file. In this case you don't need to create database manually via client. don't forget to put credentials in .env file. after completion you can use ```php artisan db:prepare``` to complete setup.

Secondly, you can directly import database.sql from project root directory.


### SETTING UP POPPLER UTILS
We already tried few of the popular PHP Libraries including IMAGICK, GIMP but none of them worked well with complex pdfs. So, we choosed Pure C++ POPPLER UTILITIES for our PDF Conversions.

Installing POPPLER procedures varies with system. Most of the linux distros has default POPPLER UTILS. If you don't have you can check this documentaion [here](https://howtoinstall.co/en/poppler-utils)

POPPLER UTILS needs LIB64 C++ headers to work. You need to install or find your lib64 binary path and put in to ENV file(LIB64_PATH).

