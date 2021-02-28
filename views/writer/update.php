<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Writer */
/* @var $modelUser app\models\User */

$this->title = Yii::t('app', 'Update Writer: {name}', [
    'name' => $model->name,
]);
//$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Writers'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
//$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="writer-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelUser' => $modelUser,
    ]) ?>

</div>
