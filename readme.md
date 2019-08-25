
<p align="center">
<a href="https://travis-ci.com/dedihartono/quarkspark-test"><img src="https://travis-ci.com/dedihartono/quarkspark-test.svg?branch=master" alt="Build Status"></a>
<a href="https://opensource.org/licenses/MIT"><img src="https://img.shields.io/badge/License-MIT-yellow.svg" alt="Licenses"></a>
</p>

# feature:
- Multi User role : admin and user
- SMTP Gmail
- Admin LTE Theme
- Yajra Datatable
- Support MySQL, MariaDB, PostgreSql

# use case
- Category
- Product
- User

# Instalation
1. Open terminal and Run :
2. git clone https://github.com/dedihartono/quarkspark-test.git
3. quarkspark-test
4. composer install
5. Create Database with name 'quarkspark'
6. Setting your ENV (environment)
7. php artisan migrate --seed
8. php artisan serve
Note :
PC installed PHP 7.1++
PC installer composer

# Setting ENV SMTP Gmail
  
    MAIL_DRIVER=smtp
    MAIL_HOST=smtp.googlemail.com
    MAIL_PORT=465
    MAIL_USERNAME=yourmail@gmail.com
    MAIL_PASSWORD=yourpassword
    MAIL_ENCRYPTION=ssl
    Note : it needs to cange the setting security : Less secure app access -> on 

    MAIL_DRIVER=smtp
    MAIL_HOST=smtp.googlemail.com
    MAIL_PORT=587
    MAIL_USERNAME=yourmail@gmail.com
    MAIL_PASSWORD=yourpassword
    MAIL_ENCRYPTION=tsl
    Note : it needs to be active 2 Step Verification and use App Password feature

# Demo : http://quarkspark.herokuapp.com/
- email : admin@example.com 
- password: 123456 (admin)

and for see others users, you can open on application on user menu
and the password is : secret
 
