<?php 
use \yii\helpers\Html;
?>
<div class="row-fluid">
	<h3><?php echo Html::a(Html::encode($data->title), $data->url); ?></h3>
	<p>posted by <?php echo $data->author->username . ' on ' . date('F j, Y',$data->create_time); ?></p>
	<p class='lead'>
		<?php
			echo $data->content;
		?>
	<p>
	<div class="row-fluid">
		<strong>Tags:</strong>
		<?php echo implode(', ', $data->tagLinks); ?>
		<br/>
		<?php echo Html::a('Permalink', $data->url); ?> |
		<?php echo Html::a("Comments ({$data->commentCount})",$data->url.'#comments'); ?> |
		Last updated on <?php echo date('F j, Y',$data->update_time); ?>
	</div>
</div>
