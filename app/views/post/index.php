<?php
use \yii\helpers\Html;

use app\widgets\LinkPager;

$this->title=Yii::$app->name . ' - Post';

if(!empty($_GET['tag'])) { ?>
<h1>Posts Tagged with <i><?php echo Html::encode($_GET['tag']); ?></i></h1>
<?php
}

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
