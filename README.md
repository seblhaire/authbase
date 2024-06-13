# Authbase
By Sébastien L'haire](http://sebastien.lhaire.org)

This library is a base package for user management and authentication that can be used by other packages, namely:

* [Seblhaire\Specialauth](https://github.com/seblhaire/specialauth)

Package [Laravel Breeze](https://laravel.com/docs/11.x/starter-kits#laravel-breeze) is very useful. However, users can register themselves automatically and this is not always convenient. 

Base package provides :

* models and table seeder
* base reset password notification
* password reset service provider
* password broker
* password set and reset email templates 
* traits to be used by other packages


force eager loading

use Seblhaire\Authbase\Traits\ProfileUtils
use Seblhaire\Authbase\Traits\RoleUtils
```
protected $with = [
        'roles',
        'profiles'
    ];
```