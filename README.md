<div align="center">
  
<a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a>
  
    
![GitHub top language](https://img.shields.io/github/languages/top/NullBrunk/E-Commerce?style=for-the-badge)
![GitHub commit activity](https://img.shields.io/github/commit-activity/m/NullBrunk/E-Commerce?style=for-the-badge)
![repo size](https://img.shields.io/github/repo-size/NullBrunk/E-Commerce?style=for-the-badge)

![image](https://user-images.githubusercontent.com/125673909/236008769-2e900822-be7e-4c74-a87e-bfcc22bd69ec.png)


</div> 

# E-Commerce
An E-Commerce website with the Laravel Framework (Currently in dev)

The Web App is iserved on localhost:80, and the API is served on localhost:8000.


# Installation

```sql
CREATE DATABASE ecommerce;
use ecommerce;

CREATE TABLE users(
    `id` INT AUTO_INCREMENT,
    `mail` VARCHAR(50) UNIQUE NOT NULL,
    `pass` VARCHAR(130) NOT NULL,
    `is_admin` SMALLINT DEFAULT 0,

    PRIMARY KEY(`id`)   
);

CREATE TABLE cart(
    `id` INT AUTO_INCREMENT,
    `id_user` INT NOT NULL,
    `id_product` INT NOT NULL,

    PRIMARY KEY(`id`),
    FOREIGN KEY(`id_user`) REFERENCES users(`id`),
    FOREIGN KEY(`id_product`) REFERENCES products(`id`)
);

CREATE TABLE products(
    `id` INT AUTO_INCREMENT,
    `id_user` INT NOT NULL,
    `name` VARCHAR(45) NOT NULL,
    `price` VARCHAR(20),
    `descr` TEXT,
    `class` TEXT,
    `image` VARCHAR(50) NOT NULL,

    FOREIGN KEY(`id_user`) REFERENCES users(`id`),
    PRIMARY KEY(`id`)
);

CREATE TABLE comments(
    `id` INT AUTO_INCREMENT,
    `id_product` INT NOT NULL, 
    `id_user` INT NOT NULL,
    `title` VARCHAR(45) NOT NULL,
    `content` TEXT NOT NULL,
    `writed_at` DATETIME NOT NULL,

    PRIMARY KEY(`id`),
    FOREIGN KEY(`id_user`) REFERENCES users(`id`),
    FOREIGN KEY(`id_product`) REFERENCES product(`id`)
);

CREATE TABLE contact(
    `id` INT AUTO_INCREMENT,
    `readed` BOOL,
    `id_contactor` INT NOT NULL,
    `id_contacted` INT NOT NULL,
    `content` TEXT NOT NULL,
    `time` DATETIME NOT NULL,s

    FOREIGN KEY(`id_contactor`) REFERENCES users(id),
    FOREIGN KEY(`id_contacted`) REFERENCES users(id),

    PRIMARY KEY(`id`)
);

```

```bash
# Start the MySQL service
php artisan mysql

# Link the storage directory to public/storage/
php artisan storage:link
```

# Serve on Apache

First of all we need to serv the web serv on port 80 and the API on the port 8000, so go into /etc/apache2/ports.conf and add 
```
Listen 8000
```
Under the `Listen 80` line.

You'll also need to sudo nano /etc/apache2/sites-enabled/000-default.conf and change the port 8000 like this :
<br>
Replace
```
<VirtualHost *:80>
```
By 
```
<VirtualHost *:80 *:8000>
```
<br>
<br>

Then clone the repository, and give all perm's to the www-data user :
<br>
```
cd /var/www/html
git clone https://github.com/NullBrunk/E-Commerce/
sudo chown www-data:www-data -R * .*
```
<br>
With all this done, let's point to the right directory : you'll need to edit the /etc/apache2/sites-enabled/000-default.conf file. Change the 
```
DocumentRoot /var/www/html
``` 

to

``` 
DocumentRoot /var/www/html/E-Commerce/public
```
<br>
Now, you'll need to enable apache rewriting module AND set AllowOverride to All.
To allow mod_rewrite, type
```
sudo a2enmod rewrite 
```
<br>
Now you need to `sudo nano /etc/apache2/apache2.conf` and search for <Directory /var/www/>.
Replace the "AllowOverride None" by an "AllowOverride All".

<br>
Ggs, You can finally start restart apache and see the result :

```
sudo systemctl restart apache2
```
And open http://127.0.0.1 on your browser