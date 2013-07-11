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
	    if($error=Yii::$app->errorHandler->exception)
	    {
		echo $error->statusCode;exit;
		var_dump($error);exit;
	    	if(Yii::$app->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	return $this->render('error', $error);
	    }
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model = new ContactForm;
		if ($model->load($_POST) && $model->contact(Yii::$app->params['adminEmail'])) {
			Yii::$app->session->setFlash('contact', 'Thank you for contacting us. We will respond to you as soon as possible.');
			Yii::$app->response->refresh();
		} else {
			return $this->render('contact', array(
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
		if ($model->load($_POST) && $model->login()) {
			Yii::$app->response->redirect(Yii::$app->user->returnUrl);
		} else {
			return $this->render('login', array(
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
