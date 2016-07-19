<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Order */

$this->title = 'View Order';
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-view">
    <h1><?= Html::encode($this->title) ?></h1>
    
    <?= DetailView::widget([
        'model' => $model,
		'template' => '<tr><th style="width:20%">{label}</th><td>{value}</td></tr>',
        'attributes' => [
			[
				'label' => 'Company Name',
				'value' => $model->company_name,
			],
			'loading_date',
			'unload_date',
			'location',
			//orang lapangan tidak perlu lihat harga
			[
				'label' => 'Price',
				'attribute' => 'price',
				'format' => 'Currency',
				'visible' => (Yii::$app->user->identity->group_id != 5) ? true : false,
			],
			//orang lapangan tidak perlu lihat tax
			[
				'label' => 'Tax',
				'value' => ($model->tax == 0 ? 'No Tax' : ($model->tax == 1 ? 'PPN' :'PPN + PPH')),
				'visible' => (Yii::$app->user->identity->group_id != 5) ? true : false,
			],
			'note',
			'komplen',
			[
				'label' => 'Photo',
				'value' => (!empty($model->photo) ? '../uploads/'.$model->photo : 'no photo'),
				'format' => (!empty($model->photo) ? ['image',['width'=>'400','height'=>'400']] : ['text',['width'=>'auto','height'=>'auto']]),	
			],
        ],
    ]) ?>

    <p>
        <?= ($allow_update) ? Html::a('Update', ['update', 'id' => $model->order_id], ['class' => 'btn btn-success']) : ''?>
        <?= ($allow_delete) ? Html::a('Delete', ['delete', 'id' => $model->order_id], [
																		'class' => 'btn btn-danger',
																		'data' => [
																			'confirm' => 'Are you sure you want to delete this item?',
																			'method' => 'post',
																		],
																	]) : '' ?>
	
		<?= Html::a('Back' , ['/jadwal'], [
											'class' => 'btn btn-primary',
										  ]) ?>
    </p>
</div>

<?php
$this->registerJs(
    '$("document").ready(function(){
	    
	});'
);
?>
