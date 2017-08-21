<?php

namespace macfly\taxonomy\models;

class PropertyTerm
{
    public static function create($type, $name, $value)
    {
        $createTerm    = false;

        if (is_null(($taxonomy = Taxonomy::findOne(['type' => $type, 'name' => $name])))) {
            $createTerm = true;
            $taxonomy = new Taxonomy();
            $taxonomy->type = $type;
            $taxonomy->name = $name;

            if (!$taxonomy->save()) {
                return false;
            }
        }

        if ($createTerm || is_null(($term = Term::findOne(['taxonomy_id' => $taxonomy->id, 'name' => $value])))) {
            $term = new Term();
            $term->taxonomy_id = $taxonomy->id;
            $term->name = $value;
            $term->usage_count = 0;

            if (!$term->save()) {
                return false;
            }
        }
        return $term;
    }
}
