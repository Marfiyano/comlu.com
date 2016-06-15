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
        'attributes' => [
            'company_name',
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
		'value' => ($model->photo == '') ? 'No Photo' : 'Show Photo',
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
</div>

<?php
$this->registerJs(
    '$("document").ready(function(){
	    
	});'
);
?>
