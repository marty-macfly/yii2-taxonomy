<?php

namespace macfly\taxonomy\models;

use yii\db\Expression;
use yii\helpers\ArrayHelper;

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

	public function getNEntity()
	{
		$name = explode("\\",$this->entity);
		$result = end($name);
		return $result;
	}

	public function getREntity()
	{
		return $this->entity::findOne($this->entity_id);
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
		Term::findOne($this->term_id)->updateCounters(['usage_count' => -1]);

		// Purge unused term longer than one month
		return Term::DeleteAll(['id'=>ArrayHelper::getColumn(Term::find()
				->andWhere(['<', 'updated_at', new Expression('DATE_SUB(NOW(), INTERVAL 30 DAY)')])
				->andWhere(['=','usage_count',0])
				->all(),'taxonomy_id')]);
	}

  public function __toString()
	{
    return sprintf("[entityterm][id:%d] termid:%d => %s(%d)", $this->id, $this->term_id, $this->entity, $this->entity_id);
  }

}
