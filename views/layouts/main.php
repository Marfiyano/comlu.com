<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\models\Module;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <script type="text/javascript" src="<?php echo Yii::$app->request->baseUrl; ?>/js/helper.js"></script>
    <?php $this->registerJsFile(
		    Yii::$app->request->baseUrl . '/js/helper.js',
		    [
			//'position'=>View::POS_END,
			'depends' => [\yii\web\JqueryAsset::className()]
		    ]
		); ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
	$module_model = new Module();
	$module = $module_model->getModule();
	
    NavBar::begin([
        'brandLabel' => 'My Company',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
	
	for($g=0;$g<count($module);$g++) {
		if($module[$g]->module_name == 'Login' && !Yii::$app->user->isGuest) { //ubah menu Login menjadi Logout(namauser)
			$items[] =('<li>'
						.Html::beginForm(['/site/logout'], 'post', ['class' => 'navbar-form'])
						.Html::submitButton(
								'Logout (' .Yii::$app->user->identity->username. ')',
								['class' => 'btn btn-link']
							)
						.Html::endForm()
						.'</li>');
		} else
			$items[] =  ['label' => $module[$g]->module_name, 'url' => [$module[$g]->url]];
	}
	
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $items
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Test <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
