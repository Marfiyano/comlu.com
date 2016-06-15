<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Order */
/* @var $form yii\widgets\ActiveForm */

$this->params['breadcrumbs'];
?>

<div class="order-form">

	<?php $form = ActiveForm::begin([
        'id' => 'create-order-form',
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-6\" style=\"padding-top:7px\">{input}</div>\n<div class=\"col-lg-4\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-2 control-label'],
        ],
    ]); ?>
		<?= $form->field($model, 'company_name')->textInput([
							    'placeholder' => 'PT ',
							    'value' => isset($model->company_name) ? $model->company_name : 'PT ',
							]) ?>
		<?= $form->field($model, 'loading_date')->widget(\yii\jui\DatePicker::classname(), [
			//'language' => 'ru',
			//'dateFormat' => 'yyyy-MM-dd',
		    ]) ?>
		<?= $form->field($model, 'unload_date')->widget(\yii\jui\DatePicker::classname(), [
			//'language' => 'ru',
			//'dateFormat' => 'yyyy-MM-dd',
		    ]) ?>
		<?= $form->field($model, 'location')->textArea() ?>
		<?= $form->field($model, 'price')->textInput([
							'placeholder' => 'Rp ',
							'value' => isset($model->price) ? 'Rp '.$model->price : 'Rp ',
							'onkeyup' => 'titikribuan(this)',
							'onkeydown' => 'return numbersonly(this, event)',
							'onselect' => 'return false',
							]) ?>
		<?= $form->field($model, 'tax')->radioList([
							'0' => 'No tax',
							'1' => 'With tax',
							]) ?>
		<?= $form->field($model, 'note')->textArea() ?>
		<?= $form->field($model, 'photo')->fileinput([
							'accept' => 'image/*',	      
						    ]) ?>

		<div class="controls col-lg-offset-2">
			<?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' =>'btn btn-success']) ?>
			<?= Html::a('Back' , ['/jadwal'], [
							'class' => 'btn btn-primary',
							]) ?>
		</div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$this->registerJs(
    '$("document").ready(function(){
		//console.log("hi");
	});'
);
?>