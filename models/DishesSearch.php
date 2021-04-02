<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Dishes;
use Yii;
use yii\data\SqlDataProvider;

/**
 * DishesSearch represents the model behind the search form of `app\models\Dishes`.
 */
class DishesSearch extends Dishes
{
    public $ingredientsIds; 

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status_id'], 'integer'],
            [['name','ingredientsIds'], 'safe'],
            [['ingredientsIds'], 'required'],
            [['ingredientsIds'], 'checkIngredientsCount'],
        ];
    }

    public function checkIngredientsCount($attribute, $params)
    {
        if (sizeof($this->$attribute) < 2) {
            $this->addError($attribute, 'Выберите больше ингредиентов');
        }
        if (sizeof($this->$attribute) > 5) {
            $this->addError($attribute, 'Выберите меньше ингредиентов');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Dishes::find();
        $query->joinWith(['ingredients']);
        if (Yii::$app->user->isGuest) {
            $query->where(['dishes.status_id' => 1]);
        }
       // print_r(Yii::$app->user->isGuest);exit();
        // add conditions that should always apply here
//echo $query->prepare(Yii::$app->db->queryBuilder)->createCommand()->rawSql; exit();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        }

        if ($params) {
            $ingredientsCount = sizeof($this->ingredientsIds);
            $sql = 'SELECT t0.dishes_id FROM ';
            for ($i = 0; $i < $ingredientsCount; $i++) {
                $id = $this->ingredientsIds[$i];
                $_sql = '(
                    SELECT di.dishes_id, di.`ingredients_id`
                    FROM `dishes_ingredients` di
                    WHERE di.`ingredients_id` = '.$id.'
                    ) t'.$i;
                if ($i<>0) {
                    $_sql .= ' ON t0.dishes_id=t'.$i.'.dishes_id ';
                }
                if ($i<>$ingredientsCount-1) {
                    $_sql .= ' INNER JOIN ';
                }
                $sql .= $_sql;
            }
//echo $sql;exit();
            $fullEqual = Yii::$app->db->createCommand($sql)->queryColumn();
//var_dump(count($fullEqual));exit();            
            if (count($fullEqual) > 0) {
                $query->andWhere(['dishes.id' => $fullEqual]);
                $dataProvider = new ActiveDataProvider([
                    'query' => $query,
                ]);
              
                return $dataProvider;
            } else {
                $query->where('0=1');
            }

            
            
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status_id' => $this->status_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'ingredients.name', $this->ingredients]);
//echo $query->prepare(Yii::$app->db->queryBuilder)->createCommand()->rawSql; exit();
        return $dataProvider;
    }
}
