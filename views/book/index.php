<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BookSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Books');
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php Html::a(Yii::t('app', 'Create Book'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            'name',
            'desc',
            [
                'attribute' => 'writer_id',
                'value' => 'writer.name',
                'filter' => \app\models\Writer::getList(),
            ],
            [
                'attribute' => 'created_at',
                'value' => 'createdAt',
                'filter' => false
            ],
            //'updated_at',

//            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
