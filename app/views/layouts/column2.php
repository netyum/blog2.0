<?php
use \Yii;

$this->beginContent('@app/views/layouts/main.php'); ?>
<div class="container-fluid">
  <div class="row-fluid">
    <div class="span9">
      <?php echo $content; ?>
    </div>
    <div class="span3">
      <?php if(!Yii::$app->user->isGuest) $this->widget('app\widgets\UserMenu'); ?>
	
      <?php $this->widget('app\widgets\TagCloud', array(
          'maxTags'=>Yii::$app->params['tagCloudCount'],
      )); ?>

      <?php $this->widget('app\widgets\RecentComments', array(
          'maxComments'=>Yii::$app->params['recentCommentCount'],
      )); ?>
    </div>
  </div>
</div>
<?php $this->endContent(); ?>
