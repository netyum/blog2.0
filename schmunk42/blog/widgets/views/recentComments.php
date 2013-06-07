<?php
use \yii\helpers\Html;
?>
<ul class="unstyled">
	<?php foreach($this->context->getRecentComments() as $comment): ?>
	<li><?php echo $comment->authorLink; ?> on
		<?php echo Html::a(Html::encode($comment->post->title), $comment->getUrl()); ?>
	</li>
	<?php endforeach; ?>
</ul>