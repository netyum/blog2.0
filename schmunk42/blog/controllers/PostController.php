<?php
namespace schmunk42\blog\controllers;
use \yii\web\Controller;
use \yii\data\Pagination;

use schmunk42\blog\models\Post;
use schmunk42\blog\models\Comment;
use schmunk42\blog\models\Tag;

class PostController extends Controller
{
	public $layout='column2';

	/**
	 * @var CActiveRecord the currently loaded data model instance.
	 */
	private $_model;

	public function behaviors() {
		return array(
			'AccessControl' => array(
				'class' => '\yii\web\AccessControl',
				'rules' => array(
					array(
						'allow'=>true,
				                'actions'=>array('index', 'view'),
						'roles'=>array('?')
		            		),
					array(
						'allow'=>true,
				                'roles'=>array('@'),
					),  
					array(
						'allow'=>false,  // deny all users
					),
				)
			)
		);
	}

	public function actionView($id)
	{
		$model=$this->loadModel($id);
		$comment=$this->newComment($model);
		echo $this->render('view',array(
			'model'=>$model,
			'comment'=>$comment,
		));
	}

	public function actionCreate()
	{
		$model=new Post();
		if ($this->populate($_POST, $model) && $model->save()) {
			\Yii::$app->response->redirect(array('view','id'=>$model->id));
		}

		echo $this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		if ($this->populate($_POST, $model) && $model->save()) {
			Yii::$app->response->redirect(array('view','id'=>$model->id));
		}

		echo $this->render('update',array(
			'model'=>$model,
		));
	}

	public function actionDelete($id)
	{
		// we only allow deletion via POST request
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		Yii::$app->response->redirect(array('index'));
	}

	public function actionIndex($tag='')
	{
		$query = Post::find()
			->where('status='. Post::STATUS_PUBLISHED)
			->orderBy('update_time DESC');

		if (!empty($tag))
			$query->andWhere(array('like', 'tags', '%'.$tag.'%'));
		$countQuery = clone $query;
		$pagination = new Pagination($countQuery->count());

		$models = $query->offset($pagination->offset)
				->limit($pagination->limit)
				->with('comments', 'author')
				->all();

		echo $this->render('index', array(
				'models' => $models,
				'pagination' => $pagination,
			));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$query = Post::find()
			->where('status='. Post::STATUS_PUBLISHED)
			->orderBy('create_time DESC');

		$countQuery = clone $query;
		$pagination = new Pagination($countQuery->count());
		
		$models = $query->offset($pagination->offset)
				->limit($pagination->limit)
				->all();

		echo $this->render('admin', array(
				'models' => $models,
				'pagination' => $pagination,
			));
	}

	public function actionSuggestTags($q='',$limit=20, $timestamp=0)
	{
		if(($keyword=trim($q))!=='')
		{
			$tags=Tag::suggestTags($keyword);
			if($tags!==array())
				echo implode("\n",$tags);
		}
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 */
	public function loadModel($id='')
	{
		if($this->_model===null)
		{
			if(!empty($id))
			{
				if(\Yii::$app->user->isGuest)
					$where='status='.Post::STATUS_PUBLISHED.' OR status='.Post::STATUS_ARCHIVED;
				else
					$where='';
					
				if ($where == '') {
					$this->_model=Post::find($id);
				}
				else {
					$this->_model=Post::find()->where('id=:id', array(':id'=>$id))->andWhere($where)->one();
				}
			}
			if($this->_model===null)
				throw new \yii\base\HttpException(404,'The requested page does not exist.');
		}
		return $this->_model;
	}

	protected function newComment($post)
	{
		$comment=new Comment();
		if($this->populate($_POST, $comment) && $post->addComment($comment))
		{
			if($comment->status==Comment::STATUS_PENDING)
				\Yii::$app->session->setFlash('commentSubmitted','Thank you for your comment. Your comment will be posted once it is approved.');
			\Yii::$app->response->refresh();
		}
		return $comment;
	}
}
