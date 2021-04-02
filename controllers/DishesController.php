<?php

namespace app\controllers;

use Yii;
use app\models\Dishes;
use app\models\DishesSearch;
use app\models\Ingredients;
use app\models\DishesIngredients;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;


/**
 * DishesController implements the CRUD actions for Dishes model.
 */
class DishesController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Dishes models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DishesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'actualIngredientsList' => Ingredients::find()->where(['status_id' => 1])->all(),
        ]);
    }

    /**
     * Displays a single Dishes model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Dishes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Dishes();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                foreach ($model->ingredientsIds as $ingredientId) {
                    $ingredient = Ingredients::findOne($ingredientId);
                    if ($ingredient) {
                        $model->link('ingredients', $ingredient);
                    } else {
                        $newIngredient = new Ingredients();
                        $newIngredient->name = $ingredientId;
                        $newIngredient->save();
                        $model->link('ingredients', $newIngredient);
                    }
                }
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'actualIngredientsList' => Ingredients::find()->where(['status_id' => 1])->all(),
        ]);
    }

    /**
     * Updates an existing Dishes model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->ingredientsIds = $model->ingredients;

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                DishesIngredients::deleteAll(['dishes_id' => $model->id]);                
                foreach ($model->ingredientsIds as $ingredientId) {
                    $ingredient = Ingredients::findOne($ingredientId);
                    if ($ingredient) {
                        $model->link('ingredients', $ingredient);
                    } else {
                        $newIngredient = new Ingredients();
                        $newIngredient->name = $ingredientId;
                        $newIngredient->save();
                        $model->link('ingredients', $newIngredient);
                    }
                }
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'actualIngredientsList' => Ingredients::find()->where(['status_id' => 1])->all(),
        ]);
    }

    /**
     * Deletes an existing Dishes model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Dishes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Dishes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Dishes::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionSearch()
    {
        $searchModel = new DishesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);      
    }
}
