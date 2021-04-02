<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use app\models\Statuses;

/* @var $this yii\web\View */
/* @var $searchModel app\models\IngredientsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ингредиенты';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="ingredients-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать ингредиент', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'id',
                'value' => 'id',
                'options' => ['width' => '75'],                
            ],
            'name',
            [
                'attribute' => 'status_id',
                'value' => 'status.name',
                'options' => ['width' => '150px'],
                'filter' => ArrayHelper::map(Statuses::find()->all(), 'id', 'name2'),
                'filterInputOptions' => ['class' => 'form-control form-control-sm'],
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header'=>'Действия', 
                'headerOptions' => ['width' => '80'],
                'template' => '{view}{update}{delete}{hide}{actualize}',
                'buttons' => [
                    'hide' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-remove-circle text-success"></span>',
                            $url, ['title' => 'Скрыть',]);
                    },
                    'actualize' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-ok-circle text-warning"></span>',
                            $url, ['title' => 'Актуализировать',]);
                    },                    
                ],
                'visibleButtons' => [
                    'hide' => function ($model) {
                        return $model->status_id == 1;
                    },
                    'actualize' => function ($model) {
                        return $model->status_id == 2;
                    },                    
                ],
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
