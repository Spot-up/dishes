<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\Ingredients;

/* @var $this yii\web\View */
/* @var $model app\models\DishesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dishes-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'status_id') ?>

    <?= $form->field($model, 'ingredientsIds')->widget(Select2::classname(), [
        'data' => ArrayHelper::map($actualIngredientsList, 'id', 'name'),
        'options' => ['placeholder' => 'Выберите ингредиенты ...'],
        'pluginOptions' => [
            'allowClear' => true,
            'multiple' => true,
            'maximumSelectionLength' => 5,
        ],
    ]); ?>    

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
