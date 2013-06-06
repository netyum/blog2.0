<?php
use \yii\helpers\Html;
use schmunk42\blog\models\Comment;
?>
<ul class="unstyled">
	<li><?php echo Html::a('Create New Post',array('blog/post/create')); ?></li>
	<li><?php echo Html::a('Manage Posts',array('blog/post/admin')); ?></li>
	<li><?php echo Html::a('Approve Comments',array('blog/comment/index')) . ' (' . Comment::getPendingCommentCount() . ')'; ?></li>
	<li><?php echo Html::a('Logout',array('site/logout')); ?></li>
</ul>