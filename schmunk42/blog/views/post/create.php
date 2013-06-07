<?php
$this->params['breadcrumbs']=array(
	'Create Post',
);
?>
<h1>Create Post</h1>

<?php echo $this->context->renderPartial('_form', array('model'=>$model)); ?>