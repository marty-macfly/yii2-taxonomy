<?php

namespace macfly\taxonomy\behaviors;

use macfly\taxonomy\models\PropertyTerm;

class TagTermBehavior extends PropertyTermBehavior
{

	public $type	= 'tag';
	public $name	= 'name';

  public function getTags()
	{
    $tags = [];

    foreach($this->getPropertyTerms($this->type)->all() as $property)
    {
      array_push($tags, $property->term->name);
    }

    return $tags;
  }

  public function setTags($tags)
  {
		$tags		= is_array($tags) ? $tags : explode(',', $tags);	
		$terms	= [];

		foreach($tags as $tag)
		{
			array_push($terms, PropertyTerm::Create($this->type, $this->name, $tag));
		}

		return $this->setPropertyTerms($this->type, $terms);
  }

  public function hasTag($value)
  {
		return $this->hasPropertyTerm($this->type, $this->name, $value);
  }

  public function addTag($value) 
  {
		return $this->addPropertyTerm($this->type, $this->name, $value);
  }

  public function delTag($value) 
  {
		return $this->delPropertyTerm($this->type, $this->name, $value);
  }

}
