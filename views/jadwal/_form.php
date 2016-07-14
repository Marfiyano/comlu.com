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
							'readonly' => (Yii::$app->user->identity->group_id == 5) ? true : false,
							]) ?>
		<?= //orang lapangan tidak boleh ganti tanggal
			(Yii::$app->user->identity->group_id != 5) ?
			$form->field($model, 'loading_date')->widget(\yii\jui\DatePicker::classname(), [
							//'language' => 'ru',
							//'dateFormat' => 'yyyy-MM-dd',
							]) :
			$form->field($model, 'loading_date')->textInput([
							'value' => $model->loading_date,
							'readonly' => true,
							'style' => 'width:160px'
							]) ?>
		<?= //orang lapangan tidak boleh ganti tanggal 
			(Yii::$app->user->identity->group_id != 5) ?
			$form->field($model, 'unload_date')->widget(\yii\jui\DatePicker::classname(), [
							//'language' => 'ru',
							//'dateFormat' => 'yyyy-MM-dd',
							]) :
			$form->field($model, 'unload_date')->textInput([
							'value' => $model->unload_date,
							'readonly' => true,
							'style' => 'width:160px'
							]) ?>					
		<?= $form->field($model, 'location')->textArea([
							'readonly' => (Yii::$app->user->identity->group_id == 5) ? true : false,
							]) ?>
		<?= //orang lapangan tidak perlu lihat harga
			(Yii::$app->user->identity->group_id != 5) ?
			$form->field($model, 'price')->textInput([
							'placeholder' => 'Rp ',
							'value' => isset($model->price) ? 'Rp '.$model->price : 'Rp ',
							'onkeyup' => 'titikribuan(this)',
							'onkeydown' => 'return numbersonly(this, event)',
							'onselect' => 'return false',
							]) :
			$form->field($model, 'price', ['options' => ['class' => 'form-group hide']])->textInput([
							'value' => 'Rp '.$model->price,
							'type' => 'hidden',
							])->label(false)?>
		<?= //orang lapangan tidak perlu lihat tax
			(Yii::$app->user->identity->group_id != 5) ?
			$form->field($model, 'tax')->radioList([
							'0' => 'No tax',
							'1' => 'PPN',
							'2' => 'PPN + PPH',
							]) :
			$form->field($model, 'tax', ['options' => ['class' => 'form-group hide']])->textInput([
							'value' => $model->tax,
							'type' => 'hidden',
							])->label(false)?>
		<?= $form->field($model, 'note')->textArea([
							'readonly' => (Yii::$app->user->identity->group_id == 5) ? true : false,
							]) ?>
		<?= $form->field($model, 'komplen')->textArea([
							'readonly' => (Yii::$app->user->identity->group_id == 5) ? true : false,
							]) ?>						
						
		<?= //hanya direktur dan orang lapangan yang boleh upload foto
			(Yii::$app->user->identity->group_id == 2 || Yii::$app->user->identity->group_id == 5) ? 
			$form->field($model, 'photo')->fileinput([
							'accept' => 'image/*',	      
							]) : '' ?>

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
		var addRupiah;
		var id_price = $("#order-price").val();
		if (id_price.substr(0,3) == "Rp ") {
			addRupiah = "Rp ";
			angka = id_price.substr(3);
		} else {
			addRupiah = "";
			angka = id_price;
		}
		for(g=angka.length; g>0; g--){
			//hilangkan semua titik terlebih dahulu
			angka = angka.replace(".","");
		}
		
		hasil_akhir = "";
		jumlah_angka = 0;
		for (g=angka.length; g>0; g--){
			jumlah_angka++;
			if (((jumlah_angka % 3) == 1) && (jumlah_angka != 1)){
				hasil_akhir = angka.substr(g-1,1) + "." + hasil_akhir;
			} else {
				hasil_akhir = angka.substr(g-1,1) + hasil_akhir;
			}
		}
		$("#order-price").val(addRupiah+hasil_akhir);
	});'
);
?>