<?php
use \yii\helpers\Html;
use \yii\base\Widget;

/**
 * CJuiAutoComplete displays an autocomplete field.
 *
 * CJuiAutoComplete encapsulates the {@link http://jqueryui.com/autocomplete/ JUI
 * autocomplete} plugin.
 *
 * To use this widget, you may insert the following code in a view:
 * <pre>
 * $this->widget('zii.widgets.jui.CJuiAutoComplete',array(
 *     'name'=>'city',
 *     'source'=>array('ac1','ac2','ac3'),
 *     // additional javascript options for the autocomplete plugin
 *     'options'=>array(
 *         'minLength'=>'2',
 *     ),
 *     'options'=>array(
 *         'style'=>'height:20px;',
 *     ),
 * ));
 * </pre>
 *
 * By configuring the {@link options} property, you may specify the options
 * that need to be passed to the JUI autocomplete plugin. Please refer to
 * the {@link http://api.jqueryui.com/autocomplete/ JUI AutoComplete API}
 * documentation for possible options (name-value pairs) and
 * {@link http://jqueryui.com/autocomplete/ JUI AutoComplete page} for
 * general description and demo.
 *
 * By configuring the {@link source} property, you may specify where to search
 * the autocomplete options for each item. If source is an array, the list is
 * used for autocomplete. You may also configure {@link sourceUrl} to retrieve
 * autocomplete items from an ajax response.
 *
 * @author Sebastian Thierer <sebathi@gmail.com>
 * @package zii.widgets.jui
 * @since 1.1.2
 */
class AutoComplete extends Widget
{
	public $model;

	public $field;

	public $name;

	public $options = array('autocomplete'=>'off');

        protected function resolveNameID()
        {
                if($this->name!==null)
                        $name=$this->name;
                elseif(isset($this->options['name']))
                        $name=$this->options['name'];
                elseif($this->hasModel())
                        $name=Html::getInputName($this->model,$this->attribute);
                else
                        throw new \yii\base\Exception('class must specify "model" and "attribute" or "name" property values.');

                if(($id=$this->getId(false))===null)
                {
                        if(isset($this->options['id']))
                                $id=$this->options['id'];
                        else
                                $id=Html::getInputId($name);
                }

                return array($name,$id);
        }

        /**
         * @return boolean whether this widget is associated with a data model.
         */
        protected function hasModel()
        {
                return $this->model instanceof \yii\base\Model && $this->attribute!==null;
        }

	/**
	 * @var mixed the entries that the autocomplete should choose from. This can be
	 * <ul>
	 * <li>an Array with local data</li>
	 * <li>a String, specifying a URL that returns JSON data as the entries.</li>
	 * <li>a javascript callback. Please make sure you wrap the callback with
	 * {@link CJavaScriptExpression} in this case.</li>
	 * </ul>
	 */
	public $source=array();
	/**
	 * @var mixed the URL that will return JSON data as the autocomplete items.
	 * CHtml::normalizeUrl() will be applied to this property to convert the property
	 * into a proper URL. When this property is set, the {@link source} property will be ignored.
	 */
	public $sourceUrl;

	public function init() {
		if (count($field->inputOptions)>0) {
			$this->options = array_merge($this->options, $field->inputOptions);
		}
$autoCompleteJS = <<<JS
	$('#matchInfo').autocomplete({
		source:function(query,process){
			var matchCount = this.options.items;
			$.post("/bootstrap/region",{"matchInfo":query,"matchCount":matchCount},function(respData){
				return process(respData);
			});
		},
		formatItem:function(item){
			return item["regionName"]+"("+item["regionNameEn"]+"."+item["regionShortnameEn"]+") - "+item["regionCode"];
		},
		setValue:function(item){
			return {'data-value':item["regionName"],'real-value':item["regionCode"]};
		}
	});
$('.container').on('click','.table a.delete',function() {
if(confirm('Are you sure you want to delete this item?')) {
return true;
}
return false;
});

JS;
$this->registerJs($autoCompleteJS);
?>
	}

	/**
	 * Run this widget.
	 * This method registers necessary javascript and renders the needed HTML code.
	 */
	public function run()
	{
		echo Html::activeTextInput($this->model, $this->attribute, $this->options));
		Yii::app()->getClientScript()->registerScript(__CLASS__.'#'.$id,"jQuery('#{$id}').autocomplete($options);");
	}
}
