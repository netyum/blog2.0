<?php
namespace app\actions;

use \yii\base\Action;

/**
 * ViewAction represents an action that displays a view according to a user-specified parameter.
 *
 * By default, the view being displayed is specified via the <code>view</code> GET parameter.
 * The name of the GET parameter can be customized via {@link viewParam}.
 * If the user doesn't provide the GET parameter, the default view specified by {@link defaultView}
 * will be displayed.
 *
 * Users specify a view in the format of <code>path.to.view</code>, which translates to the view name
 * <code>BasePath/path/to/view</code> where <code>BasePath</code> is given by {@link basePath}.
 *
 * Note, the user specified view can only contain word characters, dots and dashes and
 * the first letter must be a word letter.
 *
 * @property string $requestedView The name of the view requested by the user.
 * This is in the format of 'path.to.view'.
 */
class ViewAction extends Action
{
	/**
	 * @var string the name of the GET parameter that contains the requested view name. Defaults to 'view'.
	 */
	public $viewParam='view';
	/**
	 * @var string the name of the default view when {@link viewParam} GET parameter is not provided by user. Defaults to 'index'.
	 * This should be in the format of 'path.to.view', similar to that given in
	 * the GET parameter.
	 * @see basePath
	 */
	public $defaultView='index';
	/**
	 * @var string the name of the view to be rendered. This property will be set
	 * once the user requested view is resolved.
	 */
	public $view;
	/**
	 * @var string the base path for the views. Defaults to 'pages'.
	 * The base path will be prefixed to any user-specified page view.
	 * For example, if a user requests for <code>tutorial.chap1</code>, the corresponding view name will
	 * be <code>pages/tutorial/chap1</code>, assuming the base path is <code>pages</code>.
	 * The actual view file is determined by {@link CController::getViewFile}.
	 * @see CController::getViewFile
	 */
	public $basePath='pages';
	/**
	 * @var mixed the name of the layout to be applied to the views.
	 * This will be assigned to {@link CController::layout} before the view is rendered.
	 * Defaults to null, meaning the controller's layout will be used.
	 * If false, no layout will be applied.
	 */
	public $layout;

	private $_viewPath;


	/**
	 * Returns the name of the view requested by the user.
	 * If the user doesn't specify any view, the {@link defaultView} will be returned.
	 * @return string the name of the view requested by the user.
	 * This is in the format of 'path.to.view'.
	 */
	public function getRequestedView()
	{
		if($this->_viewPath===null)
		{
			if(!empty($_GET[$this->viewParam]))
				$this->_viewPath=$_GET[$this->viewParam];
			else
				$this->_viewPath=$this->defaultView;
		}
		return $this->_viewPath;
	}

	/**
	 * Resolves the user-specified view into a valid view name.
	 * @param string $viewPath user-specified view in the format of 'path.to.view'.
	 * @return string fully resolved view in the format of 'path/to/view'.
	 * @throw \yii\web\HttpException if the user-specified view is invalid
	 */
	protected function resolveView($viewPath)
	{
		if(preg_match('/^\w[\w\.\-]*$/',$viewPath))
		{
			$view=strtr($viewPath,'.','/');
			if(!empty($this->basePath))
				$view=$this->basePath.'/'.$view;
			$this->view=$view;
			return false;	
		}
		throw new \yii\web\HttpException(404,'The requested view "'. $viewPath .'" was not found.');
	}

	/**
	 * Runs the action.
	 * This method displays the view requested by the user.
	 * @throws \yii\web\HttpException if the view is invalid
	 */
	public function run()
	{
		
		$this->resolveView($this->getRequestedView());
		$controller=$this->controller;
		if($this->layout!==null)
		{
			$layout=$controller->layout;
			$controller->layout=$this->layout;
		}
		echo $controller->render($this->view);

		if($this->layout!==null)
			$controller->layout=$layout;
	}

	/**
	 * Raised right before the action invokes the render method.
	 * Event handlers can set the {@link CEvent::handled} property
	 * to be true to stop further view rendering.
	 * @param CEvent $event event parameter
	 */
	public function onBeforeRender($event)
	{
		$this->raiseEvent('onBeforeRender',$event);
	}

	/**
	 * Raised right after the action invokes the render method.
	 * @param CEvent $event event parameter
	 */
	public function onAfterRender($event)
	{
		$this->raiseEvent('onAfterRender',$event);
	}
}
