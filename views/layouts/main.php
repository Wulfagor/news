<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\assets\BootboxAsset;
use app\components\AuthWidget;
use app\components\RegWidget;
use app\components\RegSuccessWidget;

AppAsset::register($this);
BootboxAsset::overrideSystemConfirm();

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
    <meta name="viewport" content="width=768, user-scalable=no">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="dark_wrapper load_page"></div>

<div class="popup_overlay">

    <?php /* Authentication Form Widget */ ?>
    <?php echo AuthWidget::widget(); ?>
    <?php /* End Authentication Form Widget */ ?>

    <?php /* Registration Form Widget */ ?>
    <?php echo RegWidget::widget(); ?>
    <?php echo RegSuccessWidget::widget(); ?>
    <?php /* End Registration Form Widget */ ?>

</div>

<div class="wrap">

    <?= $this->render('header.php'); ?>

    <div class="container">

            <div class="<?= Yii::$app->controller->id . '-' . Yii::$app->controller->action->id; ?>">

                <?= $content ?>

            </div>

    </div>
</div>

<?= $this->render('footer.php'); ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
