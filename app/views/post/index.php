<?php
use \yii\helpers\Html;

foreach($models as $post) {
	echo $this->context->renderPartial('_view', array(
		'data'=>$post,
	));
}
?>
<div class='pagination'>
<?php
$this->widget('app\widgets\LinkPager', array('pages'=>$pages, 'header'=>''));
?>
</div>