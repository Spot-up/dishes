<?php

namespace app\controllers;

use Yii;
use app\models\Ingredients;
use app\models\IngredientsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\base\Exception;
use yii\web\Response;

/**
 * IngredientsController implements the CRUD actions for Ingredients model.
 */
class IngredientsController extends Controller
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
     * Lists all Ingredients models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new IngredientsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Ingredients model.
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
     * Creates a new Ingredients model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Ingredients();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Ingredients model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Ingredients model.
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
     * Finds the Ingredients model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Ingredients the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Ingredients::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    private function changeStatus($id,$status_id)
    {
        $model = $this->findModel($id);

        $transaction = $model::getDb()->beginTransaction();

        try {
            $model->status_id = $status_id;
            if (!$model->save()) {
                $validtionErrors = $model->errors;
                foreach ($validtionErrors as $validationError) {
                    $errorMessage = implode(';', $validationError);
                }
                throw new Exception('Ошибка при сохранении ингредиента: '.$errorMessage);
            }
            foreach ($model->dishes as $dish) {
                $dish->ingredientsIds = $dish->ingredients;
                $dish->status_id = $status_id;
                if (!$dish->save()) {
                    $validtionErrors = $dish->errors;
                    foreach ($validtionErrors as $validationError) {
                        $errorMessage = implode(';', $validationError);
                    }
                    throw new Exception('Ошибка при сохранении блюда: '.$errorMessage);
                }
            }
            Yii::$app->session->setFlash('success', "Статус успешно изменен");
            $transaction->commit();
        } catch(\Exception $e) {
            $transaction->rollBack();
            Yii::$app->session->setFlash('error', $e->getMessage()); 
        } catch(\Throwable $e) {
            $transaction->rollBack();
            Yii::$app->session->setFlash('error', $e->getMessage()); 
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionHide($id)
    {
        $this->changestatus($id,2);
    }

    public function actionActualize($id)
    {
        $this->changestatus($id,1);
    }
}
