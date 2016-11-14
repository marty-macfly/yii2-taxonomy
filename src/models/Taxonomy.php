<?php

namespace macfly\taxonomy\models;

class Taxonomy extends \mhndev\yii2TaxonomyTerm\models\Taxonomy
{
  public function getTerms()
  {
    return $this->hasMany(Term::className(), ['taxonomy_id'=>'id']);
  }
  public function __toString()
	{
    return sprintf("[taxnomy][id:%d][type:%s] name:%s", $this->id, $this->type, $this->name);
  }

}
