<?php
namespace app\controllers;
use \Yii;
use \yii\web\Controller;

use \yii\web\CaptchaAction;
use app\actions\ViewAction;

use app\models\ContactForm;
use app\models\LoginForm;

class SiteController extends Controller
{
	public $layout='column1';

	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			'captcha' => array(
				'class' => CaptchaAction::className(),
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=> ViewAction::className(),
			),
		);
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
var_dump(Yii::$app->errorHandler->exception->getMessage());exit;
	    if($error=Yii::$app->errorHandler->exception->message)
	    {
		var_dump($error);exit;
	    	if(Yii::$app->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	echo $this->render('error', $error);
	    }
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model = new ContactForm;
		if ($this->populate($_POST, $model) && $model->contact(Yii::$app->params['adminEmail'])) {
			Yii::$app->session->setFlash('contact', 'Thank you for contacting us. We will respond to you as soon as possible.');
			Yii::$app->response->refresh();
		} else {
			echo $this->render('contact', array(
				'model' => $model,
			));
		}
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model = new LoginForm();
		if ($this->populate($_POST, $model) && $model->login()) {
			Yii::$app->response->redirect(Yii::$app->user->returnUrl);
		} else {
			echo $this->render('login', array(
				'model' => $model,
			));
		}
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::$app->user->logout();
		Yii::$app->response->redirect(Yii::$app->homeUrl);
	}
}
