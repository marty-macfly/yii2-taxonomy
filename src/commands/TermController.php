<?php
namespace macfly\taxonomy\commands;

use Yii;
use yii\console\Controller;
use yii\helpers\ArrayHelper;
use yii\db\Expression;

use macfly\taxonomy\models\Term;

class TermController extends Controller
{
	public function actionIndex($delay = 30)
	{
		$expression	= 'DATE_SUB(NOW(), INTERVAL '. $delay .' DAY)';

		// Purge unused term, default is one month
		return Term::DeleteAll(['id'=>ArrayHelper::getColumn(Term::find()
			->andWhere(['<', 'updated_at', new Expression($expression)])
			->andWhere(['=','usage_count',0])
			->all(),'id')]);
	}
}
