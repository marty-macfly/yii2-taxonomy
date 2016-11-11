<?php

namespace macfly\taxonomy;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'macfly\taxonomy\controllers';
    public $defaultRoute = 'term/index';
    public function init()
    {
        parent::init();
    }
}
