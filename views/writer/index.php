<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\WriterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Writers');
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="writer-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->user->issuperadmin): ?>
        <p>
            <?= Html::a(Yii::t('app', 'Create Writer'), ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    <?php endif ?>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            'name',
            [
                'attribute' => 'user_id',
                'value' => 'user.username',
                'filter' => \app\models\User::getList(),
            ],
            [
                'attribute' => 'created_at',
                'value' => 'createdAt',
                'filter' => false
            ],
//            'updated_at',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}'
            ],
        ],
    ]); ?>


</div>
