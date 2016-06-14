<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Orders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
	<br />
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $model,
		'columns' => [
			[
				'attribute' => 'company_name',
				'headerOptions' => ['class' => 'text-center'],
				'contentOptions' => ['class' => 'text-center'],
			],
			[
				'attribute' => 'loading_date',
				'headerOptions' => ['class' => 'text-center'],
				'contentOptions' => [
					'class' => 'text-center col-lg-1 col-md-1 col-sm-1 col-xm-1',
				],
			],
			[
				'attribute' => 'unload_date',
				'headerOptions' => ['class' => 'text-center'],
				'contentOptions' => [
					'class' => 'text-center col-lg-1 col-md-1 col-sm-1 col-xm-1',
				],
			],
			[
				'attribute' => 'location',
				'headerOptions' => ['class' => 'text-center'],
				'contentOptions' => ['class' => 'text-center'],	
			],
			[
				'attribute' => 'price',
				'headerOptions' => ['class' => 'text-center'],
				'contentOptions' => [
					'class' => 'text-center col-lg-2 col-md-1 col-sm-1 col-xm-1',
				],
				'format' => 'Currency',
			],
			[
				'attribute' => 'note',
				'headerOptions' => ['class' => 'text-center'],
				'contentOptions' => [
					'class' => 'text-center col-lg-2 col-md-1 col-sm-1 col-xm-1',
				],
			],
			[
				'header' => 'Action',
				'headerOptions' => ['class' => 'text-center'],
				'contentOptions' => [
					'class' => 'text-center col-lg-1 col-md-1 col-sm-1 col-xm-1',
				],
				'class' => 'yii\grid\ActionColumn',
			],
		],
    ]); ?>
	
	<p>
        <?= Html::a('Create Order', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
</div>
