<?php
use \Yii;
use \yii\helpers\Html;

use \yii\widgets\Menu;
use \yii\widgets\Breadcrumbs;

$this->registerAssetBundle('app');
$this->beginPage();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo Html::encode($this->title); ?></title>
	<?php $this->head(); ?>
</head>

<body>

<div class="container" id="page">
	<?php $this->beginBody(); ?>
	<div class="masthead">
		<div class="navbar navbar-fixed-top">
			<div class="navbar-inner">
				<div class="container">
					<?php
					echo Html::a(Html::encode(Yii::$app->name), array('/'), array('class'=>'brand'));
					echo Menu::widget(array(
											'options' => array('class' => 'nav'),
											'items' => array(
												array('label' => 'Home', 'url' => array('/post/index')),
												array('label' => 'About', 'url'=>array('/site/page', 'view'=>'about')),
												array('label' => 'Contact', 'url' => array('/site/contact')),
												Yii::$app->user->isGuest ?
													array('label' => 'Login', 'url' => array('/site/login')) :
													array('label' => 'Logout (' . Yii::$app->user->identity->username .')' , 'url' => array('/site/logout')),
											),
					)); ?>
				</div>
			</div>
		</div>
		<!-- /.navbar -->
	</div>

	<div class="clearfix row-fluid">
		<div class="hero-unit">
			<h1><?php echo Html::encode(Yii::$app->params['title']); ?></h1>
			<p>Bootstrap theme.</p>
		</div>
	</div>
	<?php echo Breadcrumbs::widget(array(
		'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : array(),
	));?><!-- breadcrumbs -->

	<?php echo $content; ?>

	<div class="footer">
		<hr>
		<p>&copy; <?php echo Html::encode(Yii::$app->name);?> <?php echo date('Y'); ?></p>
		<p>
			<?php echo Yii::powered(); ?>
			Template by <a href="http://twitter.github.io/bootstrap/">Twitter Bootstrap</a>
		</p>
	</div><!-- footer -->
	<?php $this->endBody(); ?>
</div><!-- page -->

</body>
</html>
<?php $this->endPage(); ?>
