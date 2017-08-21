<?php

namespace macfly\taxonomy;

use Yii;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'macfly\taxonomy\controllers';
    public $defaultRoute        = 'term/index';
    public function init()
    {
        parent::init();
        if (Yii::$app instanceof \yii\console\Application) {
            $this->controllerNamespace = 'macfly\taxonomy\commands';
        }
    }
}
