<?php 
use \yii\helpers\Html;

foreach($comments as $comment): ?>
<div class="comment" id="c<?php echo $comment->id; ?>">
	<?php echo Html::a("#{$comment->id}", $comment->url, array(
		'class'=>'cid',
		'title'=>'Permalink to this comment',
	)); ?>

	<p>
		<?php echo $comment->authorLink; ?> says:
	<p>

	<p>
		<?php echo date('F j, Y \a\t h:i a',$comment->create_time); ?>
	</p>

	<p class='lead'>
		<?php echo nl2br(Html::encode($comment->content)); ?>
	</p>

</div><!-- comment -->
<?php endforeach; ?>