<?php
use \yii\helpers\Html;
use \Yii;
?>

<?php echo $this->context->renderPartial('_view', array(
	'data'=>$model,
)); ?>

<div id="comments" class="row-fluid">
	<?php if($model->commentCount>=1): ?>
		<h3>
			<?php echo $model->commentCount>1 ? $model->commentCount . ' comments' : 'One comment'; ?>
		</h3>

		<?php echo $this->context->renderPartial('_comments',array(
			'post'=>$model,
			'comments'=>$model->comments,
		)); ?>
	<?php endif; ?>

	<h3>Leave a Comment</h3>

	<?php if(Yii::$app->session->hasFlash('commentSubmitted')): ?>
		<div class="flash-success">
			<?php echo Yii::$app->session->getFlash('commentSubmitted'); ?>
		</div>
	<?php else: ?>
		<?php echo $this->context->renderPartial('/comment/_form',array(
			'model'=>$comment,
		)); ?>
	<?php endif; ?>

</div><!-- comments -->
