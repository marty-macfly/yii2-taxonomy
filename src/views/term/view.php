<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model macfly\taxonomy\models\Term */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Terms', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="term-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'taxonomy_id',
            'parent_id',
            'name',
            'slug',
            'usage_count',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
