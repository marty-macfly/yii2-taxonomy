<?php

namespace macfly\taxonomy\models;

class Term extends \mhndev\yii2TaxonomyTerm\models\Term
{

	public function getTaxonomy()
	{
		return $this->hasOne(Taxonomy::className(), ['id' => 'taxonomy_id']);

	}

  public function __toString()
	{
    return sprintf("[term][id:%d] name:%s", $this->id, $this->name);
  }

}
