<?php

use yii\grid\GridView;


$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Tabular</h1>

        <p class="lead">Let's learn more about tabular</p>

        <!--<p><a class="btn btn-lg btn-success" href="http://www.yiiframework.com">Get started with Yii</a></p>-->
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-12">
                <?= GridView::widget([
					'dataProvider' => $dataProvider,
					'columns' => [
						[
							'attribute' => 'invoice_number',
							'headerOptions' => ['class' => 'text-center'],
							'contentOptions' => ['class' => 'text-center'],	
						],
						[
							'attribute' => 'total',
							'headerOptions' => ['class' => 'text-center'],
							'contentOptions' => ['class' => 'text-center'],	
						],
						[
							'attribute' => 'create_date',
							'headerOptions' => ['class' => 'text-center'],
							'contentOptions' => ['class' => 'text-center'],	
						],
						[
							'header' => 'Action',
							'headerOptions' => ['class' => 'text-center'],
							'contentOptions' => ['class' => 'text-center'],	
						],
					],
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