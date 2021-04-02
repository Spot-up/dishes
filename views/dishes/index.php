<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use app\models\Statuses;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DishesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Блюда';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dishes-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать блюдо', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php  echo $this->render('_search', ['model' => $searchModel, 'actualIngredientsList' => $actualIngredientsList]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            [
                'label' => 'Ингредиенты',
                'attribute' => 'ingredients',
                'value' => function($model) {
                    return implode(", ", array_map(function($ar){
                            return $ar->name;
                    }, $model->ingredients));
                }         
            ],
            [
                'attribute' => 'status_id',
                'value' => 'status.name',
                'options' => ['width' => '150px'],
                'filter' => ArrayHelper::map(Statuses::find()->all(), 'id', 'name2'),
                'filterInputOptions' => ['class' => 'form-control form-control-sm'],
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
