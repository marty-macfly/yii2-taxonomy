<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model macfly\taxonomy\models\Taxonomy */

$this->title = 'Update Taxonomy: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Taxonomies', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="taxonomy-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,'terms'=>$terms,'term_assigned'=>$term_assigned
    ]) ?>

</div>
