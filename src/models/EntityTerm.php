<?php

namespace macfly\taxonomy\models;

class EntityTerm extends \mhndev\yii2TaxonomyTerm\models\EntityTerm
{

	public function rules()
	{
		return [
			[['entity'], 'required'],
			[['entity_id'], 'required'],
			[['term_id'], 'required'],
			[['entity', 'entity_id', 'term_id'], 'unique', 'targetAttribute' => ['entity', 'entity_id', 'term_id']],
		];
	}

  public function getTerm()
  {
    return $this->hasOne(Term::className(), ['id' => 'term_id']);
  }


  public function getTags()
  {
    return $this->hasMany(Tag::className(), ['id' => 'term_id']);
  }

	public function afterSave($insert, $changedAttributes)
	{
		// Increase Term usage Counter;
		return  Term::findOne($this->term_id)->updateCounters(['usage_count' => 1]);
	}


	public function afterDelete()
	{
		parent::afterDelete();

		// Decrease Term usage Counter
		return  Term::findOne($this->term_id)->updateCounters(['usage_count' => -1]);
	}

  public function __toString()
	{
    return sprintf("[entityterm][id:%d] termid:%d => %s(%d)", $this->id, $this->term_id, $this->entity, $this->entity_id);
  }

}
