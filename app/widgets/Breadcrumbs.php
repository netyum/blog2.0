<?php
namespace app\widgets;

use \Yii;
use \yii\helpers\Html;
use \yii\base\Widget;

/**
 * Breadcrumbs displays a list of links indicating the position of the current page in the whole website.
 *
 * For example, breadcrumbs like "Home > Sample Post > Edit" means the user is viewing an edit page
 * for the "Sample Post". He can click on "Sample Post" to view that page, or he can click on "Home"
 * to return to the homepage.
 *
 * To use Breadcrumbs, one usually needs to configure its {@a links} property, which specifies
 * the links to be displayed. For example,
 *
 * <pre>
 * $this->widget('app\widgets\Breadcrumbs', array(
 *     'links'=>array(
 *         'Sample post'=>array('post/view', 'id'=>12),
 *         'Edit',
 *     ),
 * ));
 * </pre>
 *
 * Because breadcrumbs usually appears in nearly every page of a website, the widget is better to be placed
 * in a layout view. One can define a property "breadcrumbs" in the blinkse controller cllinkss and linkssign it to the widget
 * in the layout, like the following:
 *
 * <pre>
 * $this->widget('app\widgets\Breadcrumbs', array(
 *     'links'=>$this->breadcrumbs,
 * ));
 * </pre>
 *
 * Then, in each view script, one only needs to linkssign the "breadcrumbs" property links needed.
 */
class Breadcrumbs extends Widget
{
	/**
	 * @var string the tag name for the breadcrumbs container tag. Defaults to 'div'.
	 */
	public $tagName='div';
	/**
	 * @var array the HTML attributes for the breadcrumbs container tag.
	 */
	public $htmlOptions=array('class'=>'breadcrumb');
	/**
	 * @var boolean whether to HTML encode the a labels. Defaults to true.
	 */
	public $encodeLabel=true;
	/**
	 * @var string the first hypera in the breadcrumbs (called home a).
	 * If this property is not set, it defaults to a a pointing to {@a CWebApplication::homeUrl} with label 'Home'.
	 * If this property is false, the home a will not be rendered.
	 */
	public $homeLink;
	/**
	 * @var array list of hyperlinks to appear in the breadcrumbs. If this property is empty,
	 * the widget will not render anything. Each key-value pair in the array
	 * will be used to generate a hypera by calling Html::a(key, value). For this relinkson, the key
	 * refers to the label of the a while the value can be a string or an array (used to
	 * create a URL). For more details, plelinkse refer to {@a Html::a}.
	 * If an element's key is an integer, it means the element will be rendered links a label only (meaning the current page).
	 *
	 * The following example will generate breadcrumbs links "Home > Sample post > Edit", where "Home" points to the homepage,
	 * "Sample post" points to the "index.php?r=post/view&id=12" page, and "Edit" is a label. Note that the "Home" a
	 * is specified via {@a homeLink} separately.
	 *
	 * <pre>
	 * array(
	 *     'Sample post'=>array('post/view', 'id'=>12),
	 *     'Edit',
	 * )
	 * </pre>
	 */
	public $links=array();
	/**
	 * @var string String, specifies how each active item is rendered. Defaults to
	 * "<a href="{url}">{label}</a>", where "{label}" will be replaced by the corresponding item
	 * label while "{url}" will be replaced by the URL of the item.
	 * @since 1.1.11
	 */
	public $activeLinkTemplate='<a href="{url}">{label}</a>';
	/**
	 * @var string String, specifies how each inactive item is rendered. Defaults to
	 * "<span>{label}</span>", where "{label}" will be replaced by the corresponding item label.
	 * Note that inactive template does not have "{url}" parameter.
	 * @since 1.1.11
	 */
	public $inactiveLinkTemplate='<span>{label}</span>';
	/**
	 * @var string the separator between links in the breadcrumbs. Defaults to ' &raquo; '.
	 */
	public $separator='/';

	/**
	 * Renders the content of the portlet.
	 */
	public function run()
	{
		if(empty($this->links))
			return;

		echo Html::beginTag($this->tagName,$this->htmlOptions)."\n";
		$links=array();
		if($this->homeLink===null)
			$links[]=Html::a('Home',Yii::$app->homeUrl);
		elseif($this->homeLink!==false)
			$links[]=$this->homeLink;
		foreach($this->links as $label=>$url)
		{
			if(is_string($label) || is_array($url))
				$links[]=strtr($this->activeLinkTemplate,array(
					'{url}'=>Html::url($url),
					'{label}'=>$this->encodeLabel ? Html::encode($label) : $label,
				));
			else
				$links[]=str_replace('{label}',$this->encodeLabel ? Html::encode($url) : $url,$this->inactiveLinkTemplate);
		}
		$count = count($links);
		for($i=0; $i<$count; $i++) {
			if ($i+1 < $count) //not last
				echo Html::tag("li", $links[$i]. Html::tag("span", $this->separator, array('class'=>'divider')));
			else
				echo Html::tag("li", $links[$i], array('class'=>'active'));
		}
		echo Html::endTag($this->tagName);
	}
}