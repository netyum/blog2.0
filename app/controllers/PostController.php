<?php
use \yii\web\Controller;
use \yii\web\Pagination;

use app\models\Post;
use app\models\Comment;

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

	public function actionView($id='')
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
			Yii::$app->response->redirect(array('view','id'=>$model->id));
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
		$pages = new Pagination($countQuery->count());

		$models = $query->offset($pages->offset)
				->limit($pages->limit)
				->with('comments', 'author')
				->all();

		echo $this->render('index', array(
				'models' => $models,
				'pages' => $pages,
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
		$pages = new Pagination($countQuery->count());
		
		$models = $query->offset($pages->offset)
				->limit($pages->limit)
				->all();

		echo $this->render('admin', array(
				'models' => $models,
				'pages' => $pages,
			));
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
				if(Yii::$app->user->isGuest)
					$where='status='.Post::STATUS_PUBLISHED.' OR status='.Post::STATUS_ARCHIVED;
				else
					$where='';
					
				if ($where == '') {
					$this->_model=Post::find($id);
				}
				else {
					$this->_model=Post::find()->where('id=:id AND '. $where, array('id'=>$id))->one();
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='comment-form')
		{
			echo CActiveForm::validate($comment);
			Yii::app()->end();
		}
		if($this->populate($_POST, $comment) && $post->addComment($comment))
		{
			if($comment->status==Comment::STATUS_PENDING)
				Yii::$app->session->setFlash('commentSubmitted','Thank you for your comment. Your comment will be posted once it is approved.');
			Yii::$app->response->refresh();
		}
		return $comment;
	}
}
