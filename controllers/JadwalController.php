<?php

namespace app\controllers;

use Yii;
use app\models\Order;
use app\models\OrderSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * JadwalController implements the CRUD actions for Order model.
 */
class JadwalController extends Controller
{
    /**
     * @inheritdoc
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
     * Lists all Order models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    /**
     * Creates a new Order model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Order();
	
        if ($model->load(Yii::$app->request->post())) {
			if (substr($_POST['Order']['price'],3) == 'Rp ')
				$model->price = str_replace('.','',substr($_POST['Order']['price'],3));
			else
				$model->price = str_replace('.','',$_POST['Order']['price']);
			
			//get uploaded photo
			$photo = \yii\web\UploadedFile::getInstance($model, 'photo');
			
			if ($photo->size !== 0)
				$model->photo = $model->company_name. ' -' .$photo->name;
			else
				$model->photo = Company::findone($model->c_id)->logo;
				
			if ($model->save()) {
				//save photo
				if ($photo->size !== 0)
				$photo->saveAs(\Yii::$app->basePath . '/uploads/' . $photo);
				
				//return $this->redirect(['view', 'id' => $model->id_order]);
				return $this->redirect(['index']);
			} else {
				echo "<pre>";
					echo "<br />";
					echo "<br />";
					echo "<br />";
					echo "<br />";
					print_r($model->getErrors());
					echo "</pre>";
				//}
			}
		}
		return $this->render('create', [
			'model' => $model,
		]);
	}
	
    /**
     * Displays a single Order model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Updates an existing Order model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_order]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Order model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Order model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Order the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Order::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
