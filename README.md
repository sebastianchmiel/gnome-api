# Gnome REST API

App with simple REST API to manage entities of Gnomes. 
Built on Symfony 5 and the API Platform. JWT authentication is used for authentication.

### How to run?
1. Clone this repository:
```
git clone https://github.com/sebastianchmiel/gnome-api
```
2. Go to project dir and install dependencies:
```
cd gnome-api
composer install
```
4. Create a .env.local file based on .env and complete the necessary parameters.
5. Create database and generate tables:
```
php bin/console doctrine:database:create
php bin/console make:migration
```
6. Generate the SSH keys for authorisation. [Instruction](https://github.com/lexik/LexikJWTAuthenticationBundle/blob/master/Resources/doc/index.md#generate-the-ssh-keys).
7. Create user:
```
php bin/console user:create
```
8. Open in browser REST API documentation e.g http://localhost/gnome-api/public/index.php/api/docs 
9. Now you can execute REST API requests!

