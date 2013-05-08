<?php
use app\widgets\LinkPager;

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
$this->widget(LinkPager::className(), array('pages'=>$pages, 'header'=>''));
?>
</div>

