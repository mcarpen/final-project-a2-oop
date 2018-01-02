# OOP DIC

## Configure Project

Copy file `parameters.php.dist` to `parameters.php` and change value accordingly to **your** environment.

## Install dependencies

> Use composer to install dependencies in *vendor/* (needed libraries).  
  Install dependencies from `composer.lock` if exist or create it.


```bash
composer install
```

> If you want to require a new dependency

```bash
composer require johndoe/library
```

## Doctrine

* Get all available commands

> Windows

```bash
vendor\bin\doctrine
```

> Mac

```bash
vendor/bin/doctrine
```

* Update schema (execute SQL statements to sync tables/columns)

> Windows

```bash
vendor\bin\doctrine orm:schema-tool:update --dump-sql --force
```

> Mac

```bash
vendor/bin/doctrine orm:schema-tool:update --dump-sql --force
```

## Shortcuts Jetbrains

* Quick open `CMD + MAJ + O` (mac) | `CTRL + N` (windows)
* Reformat code `CMD + ALT + L` (mac) | `CTRL + ALT + L` (windows)

## TODO

### Project

**Final date:** Sunday, January 7, 2018.

**Send method:** 
* GitHub (if you know how to use) and email me the repository
* Email me the project via wetransfer directly

**Email address:** thibaud.bardin+iim[at]gmail.com

*Ps: Do not send me the `vendor/` directory (or -1pt on the final grade)*

### General

Create a tiny blog website with a front and an admin part.

**Minimum pages:**

├── index.php  
├── article.php  
├── login.php  
├── logout.php  
├── admin_articles_list.php  
├── admin_articles_new.php    
├── admin_articles_edit.php  
├── admin_articles_delete.php  
├── admin_users_list.php  
├── admin_users_new.php  
├── admin_users_edit.php  
└── admin_users_delete.php  

### Pages

> All pages must have a valid navbar to navigate to all available pages (with context, when not logged, don't display admin pages in navbar).  
  Plus the username OR email of the logged in user must be present in the navbar instead of "Login".

#### Pages > Homepage (index.php)

Show all articles with a pagination (between 6-12 articles per page).  

Per article display the title, the excerpt, the creation date (and the author of the article).

#### Pages > Article (article.php)

Show one article via its id (use $_GET[]).    

The page must display the title, the content, the creation date (and the author of the article).


#### Pages > Login (login.php)

Shows a login form (username OR email + password).
  
Display when not connected.  
Redirect to homepage if user access the page while he's already logged in.  

#### Pages > Logout (logout.php)

Log out a user (destroy the session, ...) and redirect him to the homepage.

#### Pages > Admin List Pages (admin_articles_list.php AND admin_users_list.php)

Display when connected only.  
Display in a table all data of Entities (with pagination if > 100 items).  
A button to edit and remove each Entity must be present.  
Plus a button to be able to create a new article.  

#### Pages > Admin Edit Pages (admin_articles_edit.php AND admin_users_edit.php)

Display when connected only.  
I need to be able to edit (form) a single Entity via its id (use $_GET[]).  
Add a `Save` and `Cancel` button.  

#### Pages > Admin New Pages (admin_articles_new.php AND admin_users_new.php)

Display when connected only.  
I need to be able to create a new Entity (form).  

#### Pages > Admin Delete Pages (admin_articles_delete.php AND admin_users_delete.php)

Display when connected only.  
The page remove a single Entity via its id (use $_GET[]) and redirect directly to the `List` of the Entity.  

### Design

The following is greatly appreciated:

* [Bootstrap 4](http://getbootstrap.com/docs/4.0/getting-started/introduction/) for design.
* [FontAwesome](http://fontawesome.io/get-started/) for icons.

### Requirements

You must at least use (and properly configure) the following tools/libraries:

* [Composer](https://getcomposer.org/doc/)
* [Doctrine](http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/)
* [Symfony DIC](http://symfony.com/doc/current/components/dependency_injection.html)
* [Twig](https://twig.symfony.com/doc/2.x/)

### Good luck

![Good Luck](http://heyjackass.com/wp-content/uploads/2016/05/lando_goodbye.jpg)
