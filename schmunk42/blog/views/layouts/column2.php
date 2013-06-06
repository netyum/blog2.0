<?php
use \Yii;

use schmunk42\blog\widgets\UserMenu;
use schmunk42\blog\widgets\TagCloud;
use schmunk42\blog\widgets\RecentComments;

$this->beginContent('@app/views/layouts/main.php'); ?>
<div class="container-fluid">
  <div class="row-fluid">
    <div class="span9">
      <?php echo $content; ?>
    </div>
    <div class="span3">
      <?php if(!Yii::$app->user->isGuest) echo UserMenu::widget(); ?>
	
      <?php echo TagCloud::widget(array(
          'maxTags'=>10, // TODO: Module->params['tagCloudCount'],
      )); ?>

      <?php echo RecentComments::widget(array(
          'maxComments'=>10, // TODO: Yii::$app->params['recentCommentCount'],
      )); ?>
    </div>
  </div>
</div>
<?php $this->endContent(); ?>
