<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Writer */
/* @var $modelUser app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="writer-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($modelUser, 'username')->textInput(['maxlength' => 50, 'autocomplete'=>'off', 'autofocus'=>true, 'readonly' => $model->isNewRecord ? false : true]) ?>

    <?= $form->field($modelUser, 'password')->passwordInput(['maxlength' => 255, 'autocomplete'=>'off']) ?>

    <?= $form->field($modelUser, 'repeat_password')->passwordInput(['maxlength' => 255, 'autocomplete'=>'off']) ?>


    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
