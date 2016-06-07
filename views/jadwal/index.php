<?php

use yii\grid\GridView;


$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Order</h1>

        <p class="lead">Daftar Order</p>

        <!--<p><a class="btn btn-lg btn-success" href="http://www.yiiframework.com">Get started with Yii</a></p>-->
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-12">
                <?= GridView::widget([
					'dataProvider' => $dataProvider,
					'columns' => [
						[
							'attribute' => 'company_name',
							'headerOptions' => ['class' => 'text-center'],
							'contentOptions' => ['class' => 'text-center'],
						],
						[
							'attribute' => 'loading_date',
							'headerOptions' => ['class' => 'text-center'],
							'contentOptions' => ['class' => 'text-center'],	
						],
						[
							'attribute' => 'unload_date',
							'headerOptions' => ['class' => 'text-center'],
							'contentOptions' => ['class' => 'text-center'],	
						],
						[
							'attribute' => 'location',
							'headerOptions' => ['class' => 'text-center'],
							'contentOptions' => ['class' => 'text-center'],	
						],
						[
							'attribute' => 'price',
							'headerOptions' => ['class' => 'text-center'],
							'contentOptions' => ['class' => 'text-center'],	
							'format' => 'Currency',
						],
						[
							'attribute' => 'note',
							'headerOptions' => ['class' => 'text-center'],
							'contentOptions' => ['class' => 'text-center'],
						],
						[
							'header' => 'Action',
							'headerOptions' => ['class' => 'text-center'],
							'contentOptions' => ['class' => 'text-center'],	
							'class' => 'yii\grid\ActionColumn',
						],
					],
					'emptyCell' => '-',
				]); ?>

                <p><a class="btn btn-default" href="./tabular/create">Create Invoice</a></p>
            </div>
        </div>

    </div>
</div>

<?php
$this->registerJs(
	'$(document).ready(function(){
		console.log("Ready");
	});', 
	\yii\web\View::POS_READY
); ?>