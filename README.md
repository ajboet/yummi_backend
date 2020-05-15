# The Yummi Pizza (Backend)

> Laravel based API RESTful backend for a Pizza Delivery App.


## Installation


* Clone repo:

```
git clone https://github.com/ajboet/yummi_backend.git
```

* Create DB:

```
mysql> CREATE DATABASE your_database_name;
```

* Enter to the repo:

```
cd yummi_backend
```

* Config. the Enviroment variables:

```
cp .env.example .env
```

* Resolve dependencies / Install packages for the project:

```
composer install
```

* Generate app key:

```
php artisan key:generate
```

* Run DB migrations:

```
php artisan migrate
```

* Fill DB with the initial data:

```
php artisan db:seed
```
----


## Testing


* To start a development test server, run:

```
php artisan serve
```
