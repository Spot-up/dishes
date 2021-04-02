<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Dishes */

$this->title = 'Редактирование блюда: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Блюда', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="dishes-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'actualIngredientsList' => $actualIngredientsList,        
    ]) ?>

</div>
