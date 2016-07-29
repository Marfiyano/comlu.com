<?php

namespace app\controllers;

use Yii;
use app\models\Order;
use app\models\Group_Priv;
use app\models\Module;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;

/**
 * ReportController to show highchart from php.
 */
class ReportController extends Controller
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
						'actions' => ['logout', 'index', 'create', 'view', 'update', 'delete'], // add all actions to take guest to login page
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
		$nama_company = array();
		$data = '';
		$month_list = [
						'01' => 'Januari',
						'02' => 'Februari',
						'03' => 'Maret',
						'04' => 'April',
						'05' => 'Mei',
						'06' => 'Juni',
						'07' => 'Juli',
						'08' => 'Agustus',
						'09' => 'September',
						'10' => 'Oktober',
						'11' => 'November',
						'12' => 'Desember',
					];
		
		$model = new \yii\base\DynamicModel([
			'month', 'year',
		]);
		
		if(isset($_POST['DynamicModel'])) {
			$year_month = $_POST['DynamicModel']['year']. '-' .$_POST['DynamicModel']['month'];
			$model->year = $_POST['DynamicModel']['year'];
			$model->month = $_POST['DynamicModel']['month'];
		}
		
		if(!isset($year_month)) {
			$year_month = date('Y'). '-' .date('m');
			$model->year = date('Y');
			$model->month = date('m');
		}
		
		$company_name = Order::find()->select('company_name')->where(['like', 'loading_date', $year_month.'%', false])->groupBy('company_name')->column();
		
		// set series
		$series = array();
		
		//variabel untuk mengecek berapa kali perusahaan yang sama melakukan order
		$repeat_order_same_company = 0;
	
		//check repeat order
		$order_id = array();
		foreach($company_name as $key=>$val) {
			$order_id[] = Order::find()->select('order_id')->where(['company_name' => $val])->andWhere(['like', 'loading_date', $year_month.'%', false])->column();
			$nama_company[] = "'".$val."'";
			$loading_date[] = Order::find()->select('loading_date')->where(['company_name' => $val])->andWhere(['like', 'loading_date', $year_month.'%', false])->column();
			$unload_date[] = Order::find()->select('unload_date')->where(['company_name' => $val])->andWhere(['like', 'loading_date', $year_month.'%', false])->column();
			$complaint[] = Order::find()->select('complaint')->where(['company_name' => $val])->andWhere(['like', 'loading_date', $year_month.'%', false])->column();
		}
		
		for($g=0;$g<count($company_name);$g++) {
			for($m=0;$m<count($unload_date[$g]);$m++) {
				$x_month = substr($loading_date[$g][$m],5,2)-1;
				if($x_month < 10)
					$x_month = '0'.$x_month;
				$x2_month = substr($unload_date[$g][$m],5,2)-1;
				if($x2_month < 10)
					$x2_month = '0'.$x2_month;
					
				$x = 'x: Date.UTC(' .substr($loading_date[$g][$m],0,4). ',' .$x_month. ',' .substr($loading_date[$g][$m],8,2). ')';
				$x2 = 'x2: Date.UTC(' .substr($unload_date[$g][$m],0,4). ',' .$x2_month. ',' .substr($unload_date[$g][$m],8,2). ')';
				$y = 'y: '.$g;
				if($complaint[$g][$m] != NULL) {
					$color = 'color: "red"';
					$url = 'url: "' .Yii::$app->getUrlManager()->getBaseUrl(). '/jadwal/view?id=' .$order_id[$g][$m]. '"';
				}
				else {
					$color = 'color: "blue"';
					$url = 'url: "ayam"';
				}
				$data[$g][$m] = [$x, $x2, $y, $color, $url];
			}
		}
		
		return $this->render('index',[
			'order_id' => $order_id,
			'company_name' => $nama_company,
			'model' => $model,
			'month_list' => $month_list,
			'data' => $data
		]);
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
			$module_model = new Module();
			
			$module_id = $module_model->getModule(Yii::$app->controller->id)[0]->module_id;
			$access_priv = $gp_model->getPriv(Yii::$app->user->identity->group_id, $module_id);
			
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
				if (substr($_POST['Order']['price'],0,3) == 'Rp ')
					$model->price = str_replace('.','',substr($_POST['Order']['price'],3));
				else
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
		$allow_view = false;
		$allow_update = false;
		$allow_delete = false;
		
		if(!Yii::$app->user->isGuest) {
			$gp_model = new Group_Priv();
			$module_model = new Module();
			
			$module_id = $module_model->getModule(Yii::$app->controller->id)[0]->module_id;
			$access_priv = $gp_model->getPriv(Yii::$app->user->identity->group_id, $module_id);
			
			if(count($access_priv)>0) {
				for($g=0;$g<count($access_priv);$g++) {
					if($access_priv[$g] == 'lihat')
						$allow_view = true;
					if($access_priv[$g] == 'update')
						$allow_update = true;
					if($access_priv[$g] == 'hapus')
						$allow_delete = true;
				}
			}
		}
		
		if($allow_view) { //check permission
			$model = $this->findModel($id);
			
			if(!empty($model->photo)) { 
				$photo_name = explode("-",$model->photo);
				$model->photo = $photo_name[1];
			}
			
			return $this->render('view', [
				'model' => $model,
				'allow_view' => $allow_view,
				'allow_update' => $allow_update,
				'allow_delete' => $allow_delete,
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
		$allow_update = false;
		if(!Yii::$app->user->isGuest) {
			$gp_model = new Group_Priv();
			$module_model = new Module();
			
			$module_id = $module_model->getModule(Yii::$app->controller->id)[0]->module_id;
			$access_priv = $gp_model->getPriv(Yii::$app->user->identity->group_id, $module_id);
			
			if(count($access_priv)>0) {
				for($g=0;$g<count($access_priv);$g++) {
					if($access_priv[$g] == 'update')
						$allow_update = true;
				}
			}
		}
		
		if($allow_update) { //check permission
			$model = $this->findModel($id);
			
			if ($model->load(Yii::$app->request->post())) {
				if (substr($_POST['Order']['price'],0,3) == 'Rp ')
					$model->price = str_replace('.','',substr($_POST['Order']['price'],3));
				else
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
					
					return $this->redirect(['view', 'id' => $model->order_id]);
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
		$allow_delete = false;
		if(!Yii::$app->user->isGuest) {
			$gp_model = new Group_Priv();
			$module_model = new Module();
			
			$module_id = $module_model->getModule(Yii::$app->controller->id)[0]->module_id;
			$access_priv = $gp_model->getPriv(Yii::$app->user->identity->group_id, $module_id);
			
			if(count($access_priv)>0) {
				for($g=0;$g<count($access_priv);$g++) {
					if($access_priv[$g] == 'hapus')
						$allow_delete = true;
				}
			}
		}
		
		if($allow_delete) { //check permission
			$model = $this->findModel($id);
			$model->status_order='0';
			$model->save();

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
