<?php
namespace macfly\taxonomy\controllers;

use yii\console\Controller;
use macfly\taxonomy\models\Term;


//cronjob to delete all ununsed term
class TermcrController extends Controller {
     public function actionIndex()
     {
        Term::DeleteAll(['usage_count'=>0]);
     }
}
