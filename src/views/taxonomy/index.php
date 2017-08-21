<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use macfly\taxonomy\models\Term;

/* @var $this yii\web\View */
/* @var $searchModel macfly\taxonomy\models\TaxonomySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Taxonomies Management';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="taxonomy-index">

    <h1 class="text-center"><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]);?>

    <p>
        <?= Html::a('Create Taxonomy', ['create'], ['class' => 'btn btn-success']) ?>
          <?= Html::a('Term', ['term/index'], ['class' => 'btn btn-default pull-right']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'type',
            'name',
            'created_at',
            'term' => [
              'label' => 'Terms',
              'attribute' => 'term_name',
              'content' => function ($model) {
                  return implode(', ', ArrayHelper::getColumn($model->terms, 'name'));
              },
            ],
            [
              'class' => 'yii\grid\ActionColumn',
              'header'=> 'Action',
              'template' => '{view}{update}{del}',
              'buttons' => [
                  'del' => function ($url, $model) {
                      return $model->terms != null
                    ? Html::a('', ['taxonomy/delete', 'id'=>$model->id], [
                        'title' => 'Delete',
                        'class' => 'glyphicon glyphicon-trash',
                        'data' => [
                          'confirm' => "Are you sure you want to delete profile?",
                          'method' => 'post',
                        ],
                      ])
                    : '';
                  },
              ],
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
