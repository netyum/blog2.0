<?php
namespace schmunk42\blog\widgets;

use \yii\helpers\Html;
use \yii\base\Widget;

/**
 * Portlet is the base class for portlet widgets.
 *
 * A portlet displays a fragment of content, usually in terms of a block
 * on the side bars of a Web page.
 *
 * To specify the content of the portlet, override the {@link renderContent}
 * method, or insert the content code between the {@link CController::beginWidget}
 * and {@link CController::endWidget} calls. For example,
 *
 *
 * A portlet also has an optional {@link title}. One may also override {@link renderDecoration}
 * to further customize the decorative display of a portlet (e.g. adding min/max buttons).
 *
 */
class Portlet extends Widget
{
	/**
	 * @var string the tag name for the portlet container tag. Defaults to 'div'.
	 */
	public $tagName='div';
	/**
	 * @var array the HTML attributes for the portlet container tag.
	 */
	public $htmlOptions=array('class'=>'portlet');
	/**
	 * @var string the title of the portlet. Defaults to null.
	 * When this is not set, Decoration will not be displayed.
	 * Note that the title will not be HTML-encoded when rendering.
	 */
	public $title;
	/**
	 * @var string the CSS class for the decoration container tag. Defaults to 'portlet-decoration'.
	 */
	public $decorationCssClass='';
	/**
	 * @var string the CSS class for the portlet title tag. Defaults to 'portlet-title'.
	 */
	public $titleCssClass='portlet-title';
	/**
	 * @var string the CSS class for the content container tag. Defaults to 'portlet-content'.
	 */
	public $contentCssClass='portlet-body';
	/**
	 * @var boolean whether to hide the portlet when the body content is empty. Defaults to true.
	 * @since 1.1.4
	 */
	public $hideOnEmpty=true;

	private $_beginTag;

	/**
	 * Initializes the widget.
	 * This renders the open tags needed by the portlet.
	 * It also renders the decoration, if any.
	 */
	public function init()
	{
		ob_start();
		ob_implicit_flush(false);

		$this->htmlOptions['id']=$this->getId();
		echo Html::beginTag($this->tagName,$this->htmlOptions)."\n";
		$this->renderDecoration();
		echo "<div class=\"{$this->contentCssClass}\">\n";

		$this->_beginTag=ob_get_contents();
		ob_clean();
	}

	/**
	 * Renders the content of the portlet.
	 */
	public function run()
	{
		$this->renderContent();
		$content=ob_get_clean();
		if($this->hideOnEmpty && trim($content)==='')
			return;
		echo $this->_beginTag;
		echo $content;
		echo '</div>';
		echo Html::endTag($this->tagName);
	}

	/**
	 * Renders the decoration for the portlet.
	 * The default implementation will render the title if it is set.
	 */
	protected function renderDecoration()
	{
		if($this->title!==null)
		{
                        echo "<h4 class=\"{$this->titleCssClass}\">{$this->title}</h4>\n";
		}
	}

	/**
	 * Renders the content of the portlet.
	 * Child classes should override this method to render the actual content.
	 */
	protected function renderContent()
	{
	}
}
