<?php
use \Yii;
use \yii\helpers\Html;

$this->title=Yii::$app->name . ' - Login';
$this->params['breadcrumbs']=array(
	'Login',
);
?>

<h1>Login</h1>

<p>Please fill out the following form with your login credentials:</p>

<?php $form=$this->beginWidget('\yii\widgets\ActiveForm', array(
	'id'=>'login-form',
	'options' => array('class' => 'form-horizontal')
)); ?>

	<?php echo $form->field($model,'username')->textInput(); ?>
	<?php echo $form->field($model,'password')->passwordInput(); ?>
	<div class="controls">
		Hint: You may login with <tt>demo/demo</tt>.
	</div>
	<?php echo $form->field($model, 'rememberMe')->checkbox(); ?>
	<div class="form-actions">
		<?php echo Html::submitButton('Login', null, null, array('class' => 'btn btn-primary')); ?>
	</div>
<?php $this->endWidget(); ?>
