<?php
use \yii\helpers\Html;

use app\widgets\LinkPager;

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
