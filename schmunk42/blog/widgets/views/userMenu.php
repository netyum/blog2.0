<?php
use \yii\helpers\Html;
use schmunk42\blog\models\Comment;
?>
<ul class="unstyled">
	<li><?php echo Html::a('Create New Post',array('post/create')); ?></li>
	<li><?php echo Html::a('Manage Posts',array('post/admin')); ?></li>
	<li><?php echo Html::a('Approve Comments',array('comment/index')) . ' (' . Comment::getPendingCommentCount() . ')'; ?></li>
	<li><?php echo Html::a('Logout',array('site/logout')); ?></li>
</ul>