<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Dishes */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dishes-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ingredientsIds')->widget(Select2::classname(), [
        'data' => ArrayHelper::map($actualIngredientsList, 'id', 'name'),
        'options' => ['placeholder' => 'Выберите ингредиенты ...'],
        'pluginOptions' => [
            'allowClear' => true,
            'multiple' => true,
            'tags' => true,
        ],
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
