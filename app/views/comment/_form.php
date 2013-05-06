<?php
use \yii\helpers\Html;

?>


<?php $form = $this->beginWidget('\yii\widgets\ActiveForm'); ?>
	<?php echo $form->field($model,'author')->textInput(); ?>
	<?php echo $form->field($model,'email')->textInput(); ?>
	<?php echo $form->field($model,'url')->textInput(); ?>
	<?php echo $form->field($model,'content')->textArea(array('rows'=>6, 'cols'=>50)); ?>
	<div class="form-actions">
		<?php echo Html::submitButton('Save', null, null, array('class' => 'btn btn-primary')); ?>
	</div>

<?php $this->endWidget(); ?>