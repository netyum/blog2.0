yii2-blog
=========

*This is an extension to test package integration in Yii 2*

**DO NOT USE FOR PRODUCTION!** Go to [phundament.com](http://phundament.com) if need a production ready system.

This extension is based on [great work of netyum](https://github.com/netyum/blog2.0/).

## Deployment

```
php composer.phar self-update
php composer.phar create-project yiisoft/yii2-app-advanced
php composer.phar require schmunk42/yii2-blog:dev-master

./yii migrate --migrationPath=@vendor/schmunk42/yii2-blog/schmunk42/blog/migrations
```

## Test it!

*Note: Several glitches ahead!*

Only tested in yii2-advanced so far.

Open `http://yii2-advanced/frontend/www/index.php?r=blog/post`