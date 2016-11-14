<?php
namespace macfly\taxonomy\controllers;

use Yii;
use yii\console\Controller;
use macfly\taxonomy\models\Term;
use yii\helpers\ArrayHelper;
use yii\db\Expression;

//cronjob to delete all ununsed term
class TermcrController extends Controller {
     public function actionIndex()
     {
       $expression = isset(Yii::$app->params['termPeriod']) ? 'DATE_SUB(NOW(), INTERVAL '.Yii::$app->params['termPeriod'].' DAY)' : 'DATE_SUB(NOW(), INTERVAL 30 DAY)';
       // Purge unused term, default is one month
       return Term::DeleteAll(['id'=>ArrayHelper::getColumn(Term::find()
           ->andWhere(['<', 'updated_at', new Expression($expression)])
           ->andWhere(['=','usage_count',0])
           ->all(),'id')]);
     }
}
