<?php
use \yii\helpers\Html;

use app\widgets\LinkPager;

use app\models\Lookup;

$this->params['breadcrumbs']=array(
	'Manage Posts',
);

$deleteJS = <<<DEL
$('.container').on('click','.table a.delete',function() {
	if(confirm('Are you sure you want to delete this item?')) {
		return true;
	}
	return false;
});

DEL;
$this->registerJs($deleteJS);
?>
<h1>Manage Posts</h1>


<table class="table">
	<tr>
		<th>#</th>
		<th>title</th>
		<th>status</th>
		<th>create_time</th>
		<th><td>
	</tr>
	<?php
	if (count($models) > 0) {
		foreach($models as $model) {
	?>
	<tr>
		<td><?php echo $model->id;?></td>
		<td><?php echo Html::a(Html::encode($model->title), $model->url);?></td>
		<td><?php echo Lookup::item("PostStatus",$model->status);?></td>
		<td><?php echo date("Y/m/d", $model->create_time);?></td>
		<td>
			<?php
				echo Html::a("Update", array("update", "id"=>$model->id)); 
			?> |
			<?php
				echo Html::a("Delete", array("delete", "id"=>$model->id), array('class'=>'delete'));
			?>
		<td>
	</tr>
	<?php
		}
	}
	else {
	?>
	<tr>
		<td cols="5">not result.</td>
	</tr>
	<?php
	}
	?>
</table>
<div class='pagination'>
<?php
$this->widget(LinkPager::className(), array('pages'=>$pages, 'header'=>''));
?>
</div>

