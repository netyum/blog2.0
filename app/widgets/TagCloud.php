<?php
namespace app\widgets;
use \yii\helpers\Html;

use app\widgets\Portlet;
use app\models\Tag;

class TagCloud extends Portlet
{
	public $title='Tags';
	public $maxTags=20;

	protected function renderContent()
	{
		$tags=Tag::findTagWeights($this->maxTags);

		foreach($tags as $tag=>$weight)
		{
			$link=Html::a(Html::encode($tag), array('post/index','tag'=>$tag));
			echo Html::tag('span', $link, array(
				'class'=>'tag',
				'style'=>"font-size:{$weight}pt",
			))."\n";
		}
	}
}