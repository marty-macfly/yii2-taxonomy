<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model macfly\taxonomy\models\Taxonomy */
/* @var $form yii\widgets\ActiveForm */
use macfly\taxonomy\assets\ModuleAsset;

ModuleAsset::register($this);
?>

<div class="taxonomy-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="col-md-8">
      <?= $form->field($model, 'type')->textInput(['maxlength' => true]) ?>

      <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

      <div class="form-group">
          <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
      </div>
    </div>
    <div class="col-md-4">
      <select name="terms_input[]" id='terms-select' multiple='multiple'>
         <?php foreach ($terms as $item) {
    ?>
        <option value="<?php echo $item->id; ?>"<?php if (isset($term_assigned)&&in_array($item->id, $term_assigned)) {
        echo 'Selected';
    } ?>><?php echo $item->name; ?></option>
      <?php
} ?>
      </select>
  	</div>
    <?php ActiveForm::end(); ?>

</div>
