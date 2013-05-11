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
$this->widget(LinkPager::className(), array('pagination'=>$pagination));

