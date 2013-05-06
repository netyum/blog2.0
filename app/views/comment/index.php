<?php
$this->params['breadcrumbs']=array(
	'Comments',
);
?>

<h1>Comments</h1>

<?php 
foreach($models as $model) {
	echo $this->context->renderPartial('_view', array(
		'data'=>$model,
	));
}
?>
<div class='pagination'>
<?php
$this->widget('app\widgets\LinkPager', array('pages'=>$pages, 'header'=>''));
?>
</div>

