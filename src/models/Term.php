<?php

namespace macfly\taxonomy\models;

use yii\helpers\ArrayHelper;

class Term extends \mhndev\yii2TaxonomyTerm\models\Term
{

	public function getTaxonomy()
	{
		return $this->hasOne(Taxonomy::className(), ['id' => 'taxonomy_id']);

	}
	public function afterDelete()
	{
		parent::afterDelete();
		//Purge unused Taxonomy
		$tax_id_to_delete = [];
		$tax_id = ArrayHelper::getColumn(Taxonomy::find()->all(),'id');
		foreach($tax_id as $id)
		{
			if(!Term::findOne(['taxonomy_id'=>$id])) array_push($tax_id_to_delete,$id);
		}
		return Taxonomy::DeleteAll(['id'=>$tax_id_to_delete]);
	}

	public function getEntity()
  {
    return $this->hasMany(EntityTerm::className(), ['term_id' => 'id']);
  }

	//return the list of entity class compose with ID of childEntity
	public function getListEntity()
	{
			$result = [];
			foreach($this->entity as $entity)
			{
					$entity_class = "<span class='text-black-bg' title='".$entity->entity."'>". $entity->entity ." </span> | id: ". $entity->childEntity->id;
					array_push($result,$entity_class);
			}
			return $result;
	}

  public function __toString()
	{
    return sprintf("[term][id:%d] name:%s", $this->id, $this->name);
  }

}
