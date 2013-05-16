<?php
namespace app\models;
use \Yii;
use \yii\db\ActiveRecord;

class Tag extends ActiveRecord
{

	public static function tableName()
	{
		return '{{%tag}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('frequency', 'number', 'integerOnly'=>true),
			array('name', 'string', 'max'=>128),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Id',
			'name' => 'Name',
			'frequency' => 'Frequency',
		);
	}

	/**
	 * Returns tag names and their corresponding weights.
	 * Only the tags with the top weights will be returned.
	 * @param integer the maximum number of tags that should be returned
	 * @return array weights indexed by tag names.
	 */
	public static function findTagWeights($limit=20)
	{
		$models = static::find()->limit($limit)->orderBy('frequency DESC')->all();

		$total=0;
		foreach($models as $model)
			$total+=$model->frequency;

		$tags=array();
		if($total>0)
		{
			foreach($models as $model)
				$tags[$model->name]=8+(int)(16*$model->frequency/($total+10));
			ksort($tags);
		}
		return $tags;
	}

	/**
	 * Suggests a list of existing tags matching the specified keyword.
	 * @param string the keyword to be matched
	 * @param integer maximum number of tags to be returned
	 * @return array list of matching tag names
	 */
	public static function suggestTags($keyword,$limit=20)
	{
		$tags =  static::find()->where(
					array('like', 'name', '%'.strtr($keyword,array('%'=>'\%', '_'=>'\_', '\\'=>'\\\\')).'%')
				)
				->limit($limit)->orderBy('frequency DESC, Name')->all();
		$names=array();
		foreach($tags as $tag)
			$names[]=$tag->name;
		return $names;
	}

	public static function string2array($tags)
	{
		return preg_split('/\s*,\s*/',trim($tags),-1,PREG_SPLIT_NO_EMPTY);
	}

	public static function array2string($tags)
	{
		return implode(', ',$tags);
	}

	public static function updateFrequency($oldTags, $newTags)
	{
		$oldTags=self::string2array($oldTags);
		$newTags=self::string2array($newTags);
		self::addTags(array_values(array_diff($newTags,$oldTags)));
		self::removeTags(array_values(array_diff($oldTags,$newTags)));
	}

	public static function addTags($tags)
	{
		
		if (count($tags) >0) {
			$inTags = preg_replace('/(\S+)/i', '\'\1\'', $tags);
			$sql = "UPDATE {{%tag}} SET frequency=frequency+1 WHERE name IN (". join(",", $inTags) .' ) ';
			Yii::$app->db->createCommand($sql)->execute();
		
			foreach($tags as $name) {
				$model = static::find()->where('name=:name',array(':name'=>$name))->one();
				if ($model === null) {
					$tag=new Tag();
					$tag->name=$name;
					$tag->frequency=1;
					$tag->save();
				}
			}
		}
	}

	public static function removeTags($tags)
	{
		if(empty($tags))
			return;
		$inTags = preg_replace('/(\S+)/i', '\'\1\'', $tags);
		
		$sql = "UPDATE {{%tag}} SET frequency=frequency-1 WHERE name IN (". join(",", $inTags) .' ) '; 
		Yii::$app->db->createCommand($sql)->execute();

		$sql = "DELETE FROM {{%tag}} WHERE frequency<=0";
		Yii::$app->db->createCommand($sql)->execute();
	}
}
