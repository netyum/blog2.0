<?php
namespace schmunk42\blog\models;
use \common\models\User;
use \yii\db\ActiveRecord;
use \yii\helpers\Html;
use \Yii;

use schmunk42\blog\models\Comment;

class Post extends ActiveRecord
{

	const STATUS_DRAFT=1;
	const STATUS_PUBLISHED=2;
	const STATUS_ARCHIVED=3;

	private $_oldTags;

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, content, status', 'required'),
			array('status', 'in', 'range'=>array(1,2,3)),
			array('title', 'string', 'max'=>128),
			array('tags', 'match', 'pattern'=>'/^[\w\s,]+$/', 'message'=>'Tags can only contain word characters.'),
			array('tags', 'normalizeTags'),

			//array('title, status', 'safe', 'on'=>'search'),
		);
	}


	public function getComments() {
		
		return $this->hasMany('Comment', array('post_id' => 'id'))
		            ->where('status = '. Comment::STATUS_APPROVED)
					->orderBy('create_time DESC');
	}

	
	public function getAuthor() {
		return $this->hasOne('\common\models\User', array('id' => 'author_id'));
	}
	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Id',
			'title' => 'Title',
			'content' => 'Content',
			'tags' => 'Tags',
			'status' => 'Status',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'author_id' => 'Author',
		);
	}

	/**
	 * @return string the URL that shows the detail of the post
	 */
	public function getUrl()
	{
		// TODO: do not hardcode route
		return Yii::$app->controller->createUrl('blog/post/view', array(
			'id'=>$this->id,
			'title'=>$this->title,
		));
	}

	/**
	 * @return array a list of links that point to the post list filtered by every tag of this post
	 */
	public function getTagLinks()
	{
		$links=array();
		foreach(Tag::string2array($this->tags) as $tag)
			$links[]=Html::a(Html::encode($tag), array('post/index', 'tag'=>$tag), array('class'=>'label'));
		return $links;
	}

	/**
	 * Normalizes the user-entered tags.
	 */
	public function normalizeTags($attribute,$params)
	{
		$this->tags=Tag::array2string(array_unique(Tag::string2array($this->tags)));
	}

	/**
	 * Adds a new comment to this post.
	 * This method will set status and post_id of the comment accordingly.
	 * @param Comment the comment to be added
	 * @return boolean whether the comment is saved successfully
	 */
	public function addComment($comment)
	{
		if(true) // TODO: reimplement Yii::$app->params['commentNeedApproval']
			$comment->status=Comment::STATUS_PENDING;
		else
			$comment->status=Comment::STATUS_APPROVED;
		$comment->post_id=$this->id;
		return $comment->save();
	}

	/**
	 * This is invoked when a record is populated with data from a find() call.
	 */
	public function afterFind()
	{
		parent::afterFind();
		$this->_oldTags=$this->tags;
	}

	/**
	 * This is invoked before the record is saved.
	 * @return boolean whether the record should be saved.
	 */
	public function beforeSave($insert)
	{
		if (parent::beforeSave($insert)) {
			if ($insert) {
				$this->create_time=$this->update_time=time();
				$this->author_id=Yii::$app->user->identity->id;
			}
			else {
				$this->update_time=time();
			}
			return true;
		} else {
			return false;
		}
	}

	/**
	 * This is invoked after the record is saved.
	 */
	public function afterSave($insert)
	{
		parent::afterSave($insert);
		Tag::updateFrequency($this->_oldTags, $this->tags);
	}

	/**
	 * This is invoked after the record is deleted.
	 */
	public function afterDelete()
	{
		if (parent::beforeDelete()) {
			Comment::deleteAll('post_id='.$this->id);
			Tag::updateFrequency($this->tags, '');
		} else {
			return false;
		}
	}

}
