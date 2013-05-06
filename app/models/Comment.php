<?php
namespace app\models;
use \yii\db\ActiveRecord;
use \yii\helpers\Html;

class Comment extends ActiveRecord
{
	const STATUS_PENDING=1;
	const STATUS_APPROVED=2;

	public static function tableName()
	{
		return '{{%comment}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('content, author, email', 'required'),
			//array('author, email, url', 'length', 'max'=>128),
			array('email','email'),
			array('url','url'),
		);
	}

	public function getPost() {
		return $this->hasOne('Post', array('id' => 'post_id'));
	}
	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Id',
			'content' => 'Comment',
			'status' => 'Status',
			'create_time' => 'Create Time',
			'author' => 'Name',
			'email' => 'Email',
			'url' => 'Website',
			'post_id' => 'Post',
		);
	}

	/**
	 * Approves a comment.
	 */
	public function approve()
	{
		$this->status=Comment::STATUS_APPROVED;
		$this->update(array('status'));
	}

	/**
	 * @param Post the post that this comment belongs to. If null, the method
	 * will query for the post.
	 * @return string the permalink URL for this comment
	 */
	public function getUrl($post=null)
	{
		if($post===null)
			$post=$this->post;
		return $post->url.'#c'.$this->id;
	}

	/**
	 * @return string the hyperlink display for the current comment's author
	 */
	public function getAuthorLink()
	{
		if(!empty($this->url))
			return Html::a(Html::encode($this->author),$this->url);
		else
			return Html::encode($this->author);
	}

	/**
	 * @return integer the number of comments that are pending approval
	 */
	public static function getPendingCommentCount()
	{
		return static::find()->where('status='.self::STATUS_PENDING)->count();
	}

	/**
	 * @param integer the maximum number of comments that should be returned
	 * @return array the most recently added comments
	 */
	public static function findRecentComments($limit=10)
	{
		return static::find()->where('status='.self::STATUS_APPROVED)
					->orderBy('create_time DESC')
					->limit($limit)
					->with('post')->all();
	}

	/**
	 * This is invoked before the record is saved.
	 * @return boolean whether the record should be saved.
	 */
	public function beforeSave($insert)
	{
		if (parent::beforeSave($insert)) {
			if ($insert) {
				$this->create_time=time();
			}
			return true;
		} else {
			return false;
		}
	}

}