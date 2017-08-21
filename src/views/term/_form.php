<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model macfly\taxonomy\models\Term */
/* @var $form yii\widgets\ActiveForm */
use macfly\taxonomy\assets\ModuleAsset;

ModuleAsset::register($this);

?>

<div class="term-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <label for="name">Taxonomy Type</label>
		<select class="form-control select-taxonomy-type">
      <option value="not selected" selected></option>
      <?php foreach ($taxonomies as $taxonomy) {
    ?>
     <option value="<?php echo $taxonomy->type; ?>" <?php isset($model->taxonomy->type)?(strcmp($model->taxonomy->type, $taxonomy->type)==0? print 'selected="selected"':""):"" ?>><?php echo $taxonomy->type; ?></option>
     <?php
} ?>
		</select>
    <label for="name" style="margin-top:10px;">Taxonomy Name</label>
		<select class="form-control select-taxonomy-name">
      <option value="not selected" selected></option>
      <?php foreach ($taxonomies as $taxonomy) {
        ?>
     <option value="<?php echo $taxonomy->name; ?>" <?php isset($model->taxonomy->name)?(strcmp($model->taxonomy->name, $taxonomy->name)==0? print 'selected="selected"':""):"" ?>><?php echo $taxonomy->name; ?></option>
     <?php
    } ?>
		</select>
    <div class="form-group" style="margin-top:10px;">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
