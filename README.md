yii2-blog
=========

*This is an extension to test package integration in Yii 2*

**DO NOT USE FOR PRODUCTION!** Go to [phundament.com](http://phundament.com) if need a production ready system.

This extension is based on [the great work of netyum](https://github.com/netyum/blog2.0/).

## Notices

*Several glitches ahead!*

 * only tested in yii2-advanced and with MySQL so far
 * issues with controller routes
 * ...

## Get started!

1. [Download Yii 2 Phundament development branch](https://github.com/schmunk42/yii2/tree/phundament) and extract 
   or clone  `git clone -b phundament https://github.com/schmunk42/yii2.git` from GitHub, and go to `apps/advanced`

2. Make sure you've the latest [composer](http://getcomposer.org/download/) version.

3. Bootstrap project `php composer.phar create-project` and `./init`

4. Adjust your database connection in `./common/config/params.php`

5. Run migrations (2 steps): 
    `./yii migrate`
    `./yii migrate --migrationPath=@vendor/schmunk42/yii2-blog/schmunk42/blog/migrations`

6. Open `http://yii2-advanced/frontend/www/index.php?r=blog/post` to view posts.
7. Open `http://yii2-advanced/frontend/www/index.php?r=blog/post/create` to create posts (login: demo / demo)

## TODOs

* automatic detection of migrations
* automatic detection of module(?)
* ...
