<?php

namespace app\controllers;

use Yii;
use app\models\Order;
use app\models\Group_Priv;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
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
			'access' => [
				'class' => AccessControl::className(),
				//'only' => ['logout', 'signup'], //uncomment this line if you dont want all actions to take guest to login page
				'rules' => [
					[
						'actions' => ['login', 'error'],
						'allow' => true,
					],
					[
						'actions' => ['logout', 'index'], // add all actions to take guest to login page
						'allow' => true,
						'roles' => ['@'],
					],
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
		$allow_view = false;
		if(!Yii::$app->user->isGuest) {
			$gp_model = new Group_Priv();
			$access_priv = $gp_model->getPriv(Yii::$app->user->identity->group_id, 6);
			
			if(count($access_priv)>0) {
				for($g=0;$g<count($access_priv);$g++) {
					if($access_priv[$g] == 'lihat')
						$allow_view = true;
				}
			}
		}
		
		if($allow_view) { //check permission
			$model = new Order();
			$dataProvider = $model->search(Yii::$app->request->queryParams);

			return $this->render('index', [
				'model' => $model,
				'dataProvider' => $dataProvider,
			]);
		} else {
			throw new ForbiddenHttpException('You are not authorized to access this page');
		}
    }
    
    /**
     * Creates a new Order model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {	
		$allow_add = false;
		if(!Yii::$app->user->isGuest) {
			$gp_model = new Group_Priv();
			$access_priv = $gp_model->getPriv(Yii::$app->user->identity->group_id, 6);
			
			if(count($access_priv)>0) {
				for($g=0;$g<count($access_priv);$g++) {
					if($access_priv[$g] == 'tambah')
						$allow_add = true;
				}
			}
		}
			
		if($allow_add) { //check permission
			$model = new Order();
		
			if ($model->load(Yii::$app->request->post())) {
				if (substr($_POST['Order']['price'],0,3) == 'Rp ') {
				$model->price = str_replace('.','',substr($_POST['Order']['price'],3));
			} else
				$model->price = str_replace('.','',$_POST['Order']['price']);
			
			//date format php
			$model->loading_date = date('Y-m-d',strtotime($_POST['Order']['loading_date']));
			$model->unload_date = date('Y-m-d',strtotime($_POST['Order']['unload_date']));
			
			//get uploaded photo
			$photo = \yii\web\UploadedFile::getInstance($model, 'photo');
				
				if (isset($photo) && $photo->size !== 0)
					$model->photo = $model->company_name. ' -' .$photo->name;
					
				if ($model->save()) {
					if (isset($photo) && $photo->size !== 0) //save photo
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
				}
			}
			
			return $this->render('create', [
				'model' => $model,
			]);
		} else {
			throw new ForbiddenHttpException('You are not authorized to access this page');
		}
	}
	
    /**
     * Displays a single Order model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
		if(!Yii::$app->user->isGuest) { //user must be login first
			$model = $this->findModel($id);
			
			if(!empty($model->photo)) { 
				$photo_name = explode("-",$model->photo);
				$model->photo = $photo_name[1];
			}
			
			return $this->render('view', [
				'model' => $model,
			]);
		} else {
			throw new ForbiddenHttpException('You are not authorized to access this page');
		}
    }

    /**
     * Updates an existing Order model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
		if(!Yii::$app->user->isGuest) { //user must be login first
			$model = $this->findModel($id);
			
			if ($model->load(Yii::$app->request->post())) {
				if (substr($_POST['Order']['price'],0,3) == 'Rp ')
					$model->price = str_replace('.','',substr($_POST['Order']['price'],3));
				else
					$model->price = str_replace('.','',$_POST['Order']['price']);
				
				//get uploaded photo
				$photo = \yii\web\UploadedFile::getInstance($model, 'photo');
				
				if (isset($photo) && $photo->size !== 0)
					$model->photo = $model->company_name. ' -' .$photo->name;
					
				if ($model->save()) {
					if (isset($photo) && $photo->size !== 0) //save photo
						$photo->saveAs(\Yii::$app->basePath . '/uploads/' . $photo);
					
					return $this->redirect(['view', 'id' => $model->id_order]);
				} else {
					echo "<pre>";
					echo "<br />";
					echo "<br />";
					echo "<br />";
					echo "<br />";
						print_r($model->getErrors());
					echo "</pre>";
				}
			}
			
			return $this->render('update', [
				'model' => $model,
			]);
		} else {
			throw new ForbiddenHttpException('You are not authorized to access this page');
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
		if(!Yii::$app->user->isGuest) { //user must be login first
			$this->findModel($id)->delete();

			return $this->redirect(['index']);
		} else {
			throw new ForbiddenHttpException('You are not authorized to access this page');
		}
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
