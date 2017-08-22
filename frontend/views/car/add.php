<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Car */
/* @var $form ActiveForm */
?>
<div class="car-add">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'uid') ?>
        <?= $form->field($model, 'plate_number') ?>
        <?= $form->field($model, 'brand') ?>
        <?= $form->field($model, 'licheng') ?>
        <?= $form->field($model, 'chejian_date') ?>
        <?= $form->field($model, 'chexian_date') ?>
        <?= $form->field($model, 'ctime') ?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- car-add -->
