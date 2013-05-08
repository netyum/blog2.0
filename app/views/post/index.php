<?php
use \yii\helpers\Html;

use app\widgets\LinkPager;

foreach($models as $post) {
	echo $this->context->renderPartial('_view', array(
		'data'=>$post,
	));
}
?>
<div class='pagination'>
<?php
$this->widget(LinkPager::className(), array('pages'=>$pages, 'header'=>''));
?>
</div>
