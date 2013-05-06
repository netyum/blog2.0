<?php

namespace app\components;

use \yii\base\Object;
use \yii\web\Identity;

use app\models\User;

class UserIdentity extends Object implements Identity
{
	public $id;
	public $username;
	public $password;
	public $authKey;
	public $email;
	public $profile;

	public static function findIdentity($id)
	{
		return User::find($id);
	}

	public static function findByUsername($username)
	{
		$user = User::find()->where('username=:username', array('username'=>$username))->one();
		if ($user) {
			return new self($user);
		}
		else 
			return null;
	}

	public function getId()
	{
		return $this->id;
	}

	public function getAuthKey()
	{
		return $this->authKey;
	}

	public function validateAuthKey($authKey)
	{
		return $this->authKey === $authKey;
	}

	public function validatePassword($password)
	{
		return crypt($password,$this->password)===$this->password;
	}
}