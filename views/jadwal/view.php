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
			[
				'label' => 'Price',
				'attribute' => 'price',
				'format' => 'Currency',
			],
			'note',
			[
				'label' => 'Photo',
				'value' => (!empty($model->photo) ? '../uploads/'.$model->photo : 'no photo'),
				'format' => (!empty($model->photo) ? ['image',['width'=>'200','height'=>'200']] : ['text',['width'=>'auto','height'=>'auto']]),	
			],
        ],
    ]) ?>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_order], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_order], [
																		'class' => 'btn btn-danger',
																		'data' => [
																			'confirm' => 'Are you sure you want to delete this item?',
																			'method' => 'post',
																		],
																	]) ?>
	</p>
	<p>
		<?= Html::a('Back' , ['/jadwal'], [
											'class' => 'btn btn-info',
										  ]) ?>
    </p>
</div>

<?php
$this->registerJs(
    '$("document").ready(function(){
	    
	});'
);
?>
