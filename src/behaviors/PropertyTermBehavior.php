<?php

namespace macfly\taxonomy\behaviors;

use macfly\taxonomy\models\EntityTerm;
use macfly\taxonomy\models\PropertyTerm;
use macfly\taxonomy\models\Taxonomy;
use macfly\taxonomy\models\Term;

use yii\helpers\ArrayHelper;

class PropertyTermBehavior extends BaseTermBehavior
{
    public function getPropertyTerms($type)
    {
        return $this->getTerms()->joinWith('term.taxonomy')->where(['type' => $type]);
    }

    public function setPropertyTerms($type, $terms)
    {
        $terms        = is_array($terms) ? $terms : [$terms];
        $refresh      = false;
        $termsIdAdded = [];

        foreach ($terms as $term) {
            if ($term->taxonomy->type == $type) {
                array_push($termsIdAdded, $term->id);
                if (!$this->owner->hasTerm($term)) {
                    if (!$this->addTerm($term)) {
                        return false;
                    }
                    $refresh  = true;
                }
            }
        }

        $termsIdToDelete  = array_diff(ArrayHelper::getColumn($this->getPropertyTerms($type)->select(['term_id'])->asArray()->All(), 'term_id'), $termsIdAdded);

        if (count($termsIdToDelete) > 0) {
            EntityTerm::DeleteAll(['term_id' => $termsIdToDelete, 'entity_id' => $this->owner->id, 'entity' => $this->owner->className()]);
            $refresh  = true;
        }

        if ($refresh) {
            unset($this->owner->terms);
        }
    }

    public function hasPropertyTerm($type, $name, $value)
    {
        return !is_null($this->getPropertyTerms($type)->where([Taxonomy::tableName() . '.name' => $name])->andWhere([Term::tableName() . '.name' => $value])->one());
    }

    public function addPropertyTerm($type, $name, $value)
    {
        $term = PropertyTerm::create($type, $name, $value);
        return $this->addTerm($term);
    }

    public function delPropertyTerm($type, $name, $value)
    {
        $entity = $this->getPropertyTerms($type)->where([Taxonomy::tableName() . '.name' => $name])->andWhere([Term::tableName() . '.name' => $value])->one();

        if ($entity != false) {
            return $entity->delete();
        }

        return 0;
    }
}
