<?php
namespace schmunk42\blog\widgets;

use \Yii;
use \yii\helpers\Html;

use schmunk42\blog\widgets\Portlet;

class UserMenu extends Portlet
{
	public function init()
	{
		$this->title=Html::encode(Yii::$app->user->identity->username);
		parent::init();
	}

	protected function renderContent()
	{
		echo $this->render('userMenu');
	}
}