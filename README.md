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

1. Download Yii 2 development fork from [GitHub](https://github.com/schmunk42/yii2/archive/testing-extensions.zip), extract and go to `apps/advanced`

2. Adjust your database connection in `apps/advanced/common/config/params.php`

3. Make sure you've the latest [composer](http://getcomposer.org/download/) version.

4. Bootstrap project `php composer.phar create-project`

5. Run migrations (2 steps): 
    `./yii migrate`
    `./yii migrate --migrationPath=@vendor/schmunk42/yii2-blog/schmunk42/blog/migrations`

6. Open `http://yii2-advanced/frontend/www/index.php?r=blog/post` to view posts.
7. Open `http://yii2-advanced/frontend/www/index.php?r=blog/post/create` to create posts (login: demo / demo)

## TODOs

* automatic detection of migrations
* automatic detection of module(?)
* ...