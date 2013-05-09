<?php 
use \yii\helpers\Html;

if (!isset($commentCount)) {
	$commentCount = 0;
	if (is_object($data->comments)) $commentCount=$model->comments->count();
}
?>
<div class="row-fluid">
	<div class="page-header">
		<h1><?php echo Html::a(Html::encode($data->title), $data->url); ?></h1>
	</div>
	<p class="meta">Posted by <?php echo $data->author->username . ' on ' . date('F j, Y',$data->create_time); ?></p>
	<p class='lead'>
		<?php
			echo $data->content;
		?>
	<p>
	<div class="row-fluid">
		<p class="tags">
			<strong>Tags:</strong>
			<?php echo implode(' ', $data->tagLinks); ?>
		</p>
		<?php echo Html::a('Permalink', $data->url); ?> |
		<?php echo Html::a("Comments ({$commentCount})",$data->url.'#comments'); ?> |
		Last updated on <?php echo date('F j, Y',$data->update_time); ?>
	</div>
</div>
