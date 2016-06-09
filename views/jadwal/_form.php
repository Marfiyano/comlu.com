<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Order */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-form">

	<?php $form = ActiveForm::begin([
        'id' => 'create-order-form',
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-4\">{input}</div>\n<div class=\"col-lg-6\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-2 control-label'],
        ],
    ]); ?>
		
		<?= $form->field($model, 'company_name')->textInput() ?>
		<?= $form->field($model, 'loading_date')->textInput() ?>
		<?= $form->field($model, 'unload_date')->textInput() ?>
		<?= $form->field($model, 'location')->textInput() ?>
		<?= $form->field($model, 'price')->textInput() ?>
		<?= $form->field($model, 'note')->textInput() ?>
		<?= $form->field($model, 'photo')->textInput() ?>

		<div class="form-group">
			<?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		</div>

    <?php ActiveForm::end(); ?>

</div>
