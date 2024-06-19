# Authbase
By Sébastien L'haire](http://sebastien.lhaire.org)

This library is a base package for user management and authentication that can be used by other packages, namely:

* [Seblhaire\Specialauth](https://github.com/seblhaire/specialauth)

Package [Laravel Breeze](https://laravel.com/docs/11.x/starter-kits#laravel-breeze) is very useful. However, users can register themselves automatically and this is not always convenient. Instead, you could need that application accounts could be created by users with administrator rights.


Base package provides :

* models and table seeder
* base reset password notification
* password reset service provider
* password broker
* password set and reset email templates 
* traits to be used by other packages

# Installation

1. We strongly recommend that you do not install this package alone. We suggest that you install one of the above mentioned packages instead, according to your needs. But if you wish to use only this package, use `composer require seblhaire/authbase`
2. Composer will automatically link the package with Laravel. But you still can explicitely add provider and facade to your `config/app.php`:
```php
'providers' => [
    Seblhaire\Authbase\ProvidersAuthbaseServiceProvider::class,
    Seblhaire\Authbase\ProvidersPasswordResetServiceProvider::class
]
```
3. Publish package: `php artisan vendor:publish`
4. Config package (cf. [below](#configuration-file)).
5. Complete [templates](#templates).
6. Apply [database migrations](#database-migration).
7. Extend [notifications](#notifications).
8. Define [user roles and profiles](#user_roles_and_profile).

# Configuration

## Configuration file

After publishing the package, modifiy file `authbase.php` to adapt it for your application. The configuration is accessible
through

```
config('authbase')
```
* `resetpasswordnotification`:  notification class used to send password reset mail. Cf [below](#notifications).
* `createpasswordnotification`:  notification class used to send user creation mail. Cf [below](#notifications).
* `roles`:  lists [user roles](#roles) for your application. Will be used to [feed table in database](#database-migration). Default: `['administrator', 'standard_user']`.
* `profile`: lists [user profile items](#profile) for your application. Will be used to [feed table in database](#database-migration). Default: `[]`.

## Mail Configuration

Your application must be able to send mails by using one of the methods on Laravel official documentation.


# Templates

## Email templates

You should also adapt email templates to your application. Templates can be found in `resources/views/vendor/authbase/public/emails`.
You can define the header and footer for your application. All mails sent by your application can share the same layout. Finally, mail contents can be defined as in `public/emails/email.blade.php`. Feel free to adapt it to your needs. Mail contents sent by your app are described [below](#notifications).

# Database migration

This package comes with a database migration `0000_00_00_000000_baseauth_tables.php` that includes all necessary Laravel migrations.
Then run ` php artisan migrate:install`.  Make sure that [configuration file specialauth.php](#configuration-file-specialauth) is completed with [roles and profiles](#user-roles-and-profile) and finally run migration with `php artisan migrate --seed --seeder=UsersTableSeeder` to create and fill tables. Later you will need create
your [first user](#create_main_admin_account).

# Notifications

We need to set two notifications, to create password for new users, and to reset password for users that have forgotten it. This package provides abstract class `Seblhaire\Authbase\Notifications\ResetPassword` that must be extended in your application and define following methods:

* `public function buildMessage($url, $user): MailMessage`

This method must return an object of class `Illuminate\Notifications\Messages\MailMessage`


* `public function getRoute(): string;`

This method returns a string identifying the route where the user will be redirected, either to set or to reset their password.

You can copy or adapt code in `example/Notifications`and put it in directory `app/Notifications` of your application.

Then you must edit file `authbase.php` and provide notification classes, for instance:

```
return [
    'resetpasswordnotification' => App\Notifications\ResetPasswordNotification::class,
    'createpasswordnotification' => App\Notifications\CreatePasswordNotification::class,
];
```
# User roles and profile

The package modifies default Laravel user model and adds role and profile tables. Model `\Seblhaire\Specialauth\Models\User` uses Laravel standard traits and adds
Eloquent relationships to the `Role` and `Profile` model. If your app needs more relationships, such as links to logs, you can extend our `User` model.  

## Profile

You must first add profile names to the `profiles` table, such as `skin` to choose between themes, `table_max_element` to get the user favorite element number in a table, etc. When you create your app, you can define profiles items in [configuration](#Configuration_file_specialauth) and [seed](#database_migration) them into the database. You can add new profiles to new versions of your app or do it in your app.

 Profiles are attached to user through table `profile_user`. Profile value is stored in `jsonvals` pivot value. You just have to store a JSON object such as
 `{"val": 20}`, or more complex object structures.

 Profiles can be attached to users with `$user->profiles()->attach(1, ['jsonvals' => '{"val":' . config('tablebuilder.table.itemsperpage') . '}'])` where value 1 refers
 to the `id` of the profile value in table `profiles`. The config value here refers to default table size value in package [TableBuilder](https://github.com/seblhaire/tablebuilder/blob/master/config/tablebuilder.php). To change this value, we suggest to first detach value with `$user->roles()->detach(1);` and attach new value.

 If you need to access a profile value of the current user, use  `\Auth::user()->profile('table_max_element')->val` to retrieve the value of this profile item.

## Roles

First of all, you should define precisely differents roles for your app users. Usually, apps define super users who can run all actions and ordinary users that only can do ordinary tasks. But you can define more roles. When creating your application, [database migrations](#database-migration) chapter shows you how
to automatically insert your app roles. However, when updating your app you can easily create new roles, or your app could also allow users to insert new roles.

Users should have at least one role, but table structure allows users to have several roles.

To assign a role to a user, use `$user->roles()->attach(1)` to attach role with `id` 1 in table `roles`. To update roles, first detach all roles with `$user->roles()->detach()` and re-attach updated list.

If you need to know if a user has a role, use `$user->hasRole('administrator')`.

Then you must define how to use roles in your app.

### Policies and gates

Policies define conditions that must be met to allow actions that you can use in controllers. For eample, to update a user, your must either be this user or have
adminstrator role. To display information on a user, you must be this user.

Policies cannot be defined in packages and automatically be loaded. Therefore you need to define your policies. We have writen trait `Seblhaire\Authbase\Traits\PolicyTrait` that can be used in your policies. First, you must create a policy class:

```
php artisan make:policy UserPolicy
```

Then use our trait as in example `example/Policies/UserPolicy.php`. And finally, in controllers, you can use policies like this:

```
if (\Auth::user()->cant('update_user', $user)) return redirect()->route('adminhome')
```

Laravel Gates are closures that determine if a user is authorized to perform a given action. We also provide trait `Seblhaire\Authbase\Traits\GateTrait` that can be used in your provider alongside with your policies. Gates can be used as in example `example/routes/web.php`.

To use policies and gates, you must write a simple provider like provider `App\Providers\AuthServiceProvider` in example `examples/Providers/AuthServiceProvider.php`. Simply add it in your app's `config/app.php` in array `providers`.


# Traits

In `src/Traits` we provide useful traits. We have already mentioned `Seblhaire\Authbase\Traits\PolicyTrait` and `Seblhaire\Authbase\Traits\GateTrait`. 

`Seblhaire\Authbase\Traits\CanResetPassword` is based on `Illuminate\Auth\Passwords\CanResetPassword`. It is used by user model `Seblhaire\Authbase\Models\User` that can be extended by other packages and in your apps.

Traits `Seblhaire\Authbase\Traits\RoleUtils` and `Seblhaire\Authbase\Traits\ProfileUtils` provide methods to link `Seblhaire\Authbase\Models\Profile` and `Seblhaire\Authbase\Models\Role` to your user models.

# Translation keys

Original translations are stored under `vendor/seblhaire/authbase/resources/lang`. If you publish package files, you can find translations in `resources/lang/vendor/authbase/`.

Feel free to translate keys in your own language and either to send it to the author or to do a merge request on GitHub.

# Questions? Contributions?

Feel free to send feature requests or merge request to the author or simply to ask questions.
