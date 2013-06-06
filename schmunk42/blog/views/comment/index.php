<?php
use \yii\widgets\LinkPager;

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
echo LinkPager::widget(array('pagination'=>$pagination));
?>

