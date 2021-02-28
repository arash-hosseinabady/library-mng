<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Writer */
/* @var $modelUser app\models\User */

$this->title = Yii::t('app', 'Create Writer');
//$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Writers'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="writer-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelUser' => $modelUser,
    ]) ?>

</div>
