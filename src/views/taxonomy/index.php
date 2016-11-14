<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
use macfly\taxonomy\assets\ModuleAsset;

ModuleAsset::register($this);
$this->title = 'Taxonomies';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="taxonomy-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Taxonomy', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Term', ['term/index'], ['class' => 'btn btn-default pull-right']) ?>
    </p>
    <table class="table table-striped cell-border" id="list-taxonomy">
        <thead>
          <tr class="table-header">
            <th>
              #
            </th>
            <th>
              Type
            </th>
            <th>
              Name
            </th>
            <th class="text-center">
              Term
            </th>
            <th>
              Action
            </th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($taxonomies as $taxonomy): ?>
          <tr>
            <td>
            </td>
            <td>
              <?= $taxonomy->type ?>
            </td>
            <td>
              <?= $taxonomy->name ?>
            </td>
            <td>
              <?php foreach($taxonomy->terms as $term): echo "<span class='text-black-bg'>".$term->name." </span>"; endforeach; ?>
            </td>
            <td>
                <span class="pull-right">
                <?= Html::a('', ['taxonomy/view', 'id'=>$taxonomy->id], [
                  'title' => 'View',
                  'class' => 'glyphicon glyphicon-eye-open',
                  ]) ?>
                <?= Html::a('', ['taxonomy/update', 'id'=>$taxonomy->id], [
                  'title' => 'Update',
                  'class' => 'glyphicon glyphicon-pencil',
                  ]) ?>

                <?php if($taxonomy->terms == null): ?>
                <?= Html::a('', ['taxonomy/delete', 'id'=>$taxonomy->id], [
                  'title' => 'Delete',
                  'class' => 'glyphicon glyphicon-trash',
                  'data' => [
                    'confirm' => "Are you sure you want to delete profile?",
                    'method' => 'post',
                  ],
                  ]) ?>
                <?php endif; ?>
                </span>
            </td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
</div>
