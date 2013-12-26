GeekHub Homework 8-11. The Simple Guestbook.
========================

## Steps to deploy: ##

1. Clone repository to your local machine
2. Execute 'composer install' at the root directory
3. Point DocumentRoot of your web server to the 'web' directory
4. Do not forget to execute
 ```
 $ app/console assetic:dump -e prod
 ```
to install assets
5. Do not forget to deploy database structure and fixtures by executing
 ~~~
 $ app/console doctrine:schema:create
 $ app/console doctrine:fixtures:load
 ~~~
6. Configure your mailer to receive new post notification ;)
7. You can use BB-codes in message formatting. Enjoy ;)
