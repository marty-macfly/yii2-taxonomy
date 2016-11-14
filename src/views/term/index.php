<?php

use yii\helpers\Html;
use yii\grid\GridView;

use macfly\taxonomy\assets\ModuleAsset;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

ModuleAsset::register($this);
$this->title = 'TAG MANAGEMENT';
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
<table class="table table-striped cell-border" id="list-term">
    <thead>
      <tr class="table-header">
        <th>
          #
        </th>
        <th>
          Term Name
        </th>
        <th class="text-center">
          Entity
        </th>
        <th class="text-center">
          Taxonomy (type/name)
        </th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($terms as $term): ?>
      <tr>
        <td>

        </td>
        <td>
          <?php echo "<strong>".$term->name." </strong><span class='badge'>".$term->usage_count."</span>"; ?>
          <span class="pull-right">
          <?= Html::a('', ['term/view', 'id'=>$term->id], [
            'title' => 'View',
            'class' => 'glyphicon glyphicon-eye-open',
            ]) ?>
          <?= Html::a('', ['term/update', 'id'=>$term->id], [
            'title' => 'Update',
            'class' => 'glyphicon glyphicon-pencil',
            ]) ?>
          </span>
        </td>
        <td class="text-center">
          <?php
            foreach($term->entity as $item):
              echo "<span class='text-black-bg'>".$item->nentity." </span>";
              foreach($item->rentity as $key => $value): echo " | ".$key.": ".$value; endforeach;
              echo "<br>";
            endforeach;
            ?>
        </td>
        <td>
          <?php
            echo "<span class='taxonomy-type'>".$term->taxonomy->type."</span><span class='text-black-bg'>".$term->taxonomy->name."</span>";
            ?>
            <span class="pull-right">
            <?= Html::a('', ['taxonomy/view', 'id'=>$term->taxonomy->id], [
              'title' => 'View',
              'class' => 'glyphicon glyphicon-eye-open',
              ]) ?>
            <?= Html::a('', ['taxonomy/update', 'id'=>$term->taxonomy->id], [
              'title' => 'Update',
              'class' => 'glyphicon glyphicon-pencil',
              ]) ?>
            </span>
        </td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
