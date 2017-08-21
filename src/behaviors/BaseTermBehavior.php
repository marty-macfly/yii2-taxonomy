<?php

namespace macfly\taxonomy\behaviors;

use macfly\taxonomy\models\EntityTerm;
use macfly\taxonomy\models\Term;
use yii\helpers\ArrayHelper;

class BaseTermBehavior extends \yii\base\Behavior
{
    public function setTerms($terms)
    {
        $terms          = is_array($terms) ? $terms : [$terms];
        $refresh        = false;
        $termsIdAdded   = [];

        foreach ($terms as $term) {
            array_push($termsIdAdded, $term->id);
            if (!$this->owner->hasTerm($term)) {
                if (!$this->addTerm($term)) {
                    return false;
                }
                $refresh    = true;
            }
        }

        $termsIdToDelete    = array_diff(ArrayHelper::getColumn($this->getTerms()->select(['term_id'])->asArray()->All(), 'term_id'), $termsIdAdded);

        if (count($termsIdToDelete) > 0) {
            EntityTerm::DeleteAll(['term_id' => $termsIdToDelete, 'entity_id' => $this->owner->id, 'entity' => $this->owner->className()]);
            $refresh    = true;
        }

        if ($refresh) {
            unset($this->owner->terms);
        }
    }

    public function getTerms()
    {
        return $this->owner->hasMany(EntityTerm::className(), ['entity_id' => 'id'])->where(['entity' => $this->owner->className()]);
    }

    public function hasTerm(Term $term)
    {
        return !is_null($this->getTerms()->where(['term_id' => $term->id])->one());
    }

    public function addTerm(Term $term)
    {
        $record = new EntityTerm(['term_id' => $term->id, 'entity_id' => $this->owner->id, 'entity' => $this->owner->className()]);
        return $record->save();
    }

    public function delTerm(Term $term)
    {
        return $this->getTerms()->findOne(['term_id' => $term->id])->delete();
    }
}
