<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use macfly\taxonomy\assets\ModuleAsset;

/* @var $this yii\web\View */
/* @var $searchModel macfly\taxonomy\models\TermSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
ModuleAsset::register($this);
$this->title = 'Entity/Term Management';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="term-index">

    <h1 class="text-center"><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Term', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Create Taxonomy', ['taxonomy/create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Taxonomies', ['taxonomy/index'], ['class' => 'btn btn-default pull-right']) ?>
    </p>
</div>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'entity'=>[
              'label'=>'Entities',
              'content'=> function($model){
                  //return $model->hihihi;
                  return implode('<br> ',$model->listentity);
              },
            ],
            'taxonomy'=>[
              'label'=>'Taxonomy',
              'content'=> function($model){
                return "<span class='taxonomy-type'>".$model->taxonomy->type."</span><span class='text-black-bg'>".$model->taxonomy->name."</span>";
              },
            ],
            'name',
            [
              'class' => 'yii\grid\ActionColumn',
              'header'=> 'Action',
              'template' => '{view}{update}',
              'contentOptions' => ['class' => 'text-center'],
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
