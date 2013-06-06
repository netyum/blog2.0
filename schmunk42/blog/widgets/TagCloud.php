<?php
namespace schmunk42\blog\widgets;
use \yii\helpers\Html;

use schmunk42\blog\widgets\Portlet;
use schmunk42\blog\models\Tag;

class TagCloud extends Portlet
{
	public $title='Tags';
	public $maxTags=20;

	private $_labels = array();

	public function init() {
		parent::init();
		$this->_labels = array(
			'9'=>'label',
			'10'=>'label-success',
			'11'=>'label-info',
			'12'=>'label-inverse',
			'13'=>'label-important',
			'14'=>'label-warning',
		);

	}

	protected function renderContent()
	{
		$tags=Tag::findTagWeights($this->maxTags);
		foreach($tags as $tag=>$weight)
		{
			if ($weight>14) $weight=14;
			$class = 'label ';
			if (isset($this->_labels[$weight])) {
				$class .=$this->_labels[$weight];
			}
			echo Html::a(Html::encode($tag), array('post/index','tag'=>$tag), array('class'=>$class))."\n";
		}
	}
}
