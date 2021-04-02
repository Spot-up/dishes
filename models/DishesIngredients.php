<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dishes_ingredients".
 *
 * @property int $dishes_id
 * @property int $ingredients_id
 */
class DishesIngredients extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dishes_ingredients';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dishes_id', 'ingredients_id'], 'required'],
            [['dishes_id', 'ingredients_id'], 'integer'],
            [['dishes_id', 'ingredients_id'], 'unique', 'targetAttribute' => ['dishes_id', 'ingredients_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'dishes_id' => 'Dishes ID',
            'ingredients_id' => 'Ingredients ID',
        ];
    }
}
