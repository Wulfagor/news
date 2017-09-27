<?php

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\assets\AppIEAsset;
use app\assets\BootboxAsset;
use yii\helpers\Url;
use app\components\CartWidget;
use app\components\AuthWidget;
use app\components\RegWidget;
use app\components\RegSuccessWidget;
use app\components\SearchWidget;
use app\components\ContactFormWidget;
use app\components\ContactFormSuccessWidget;
use app\components\LanguageWidget;

AppAsset::register($this);
BootboxAsset::overrideSystemConfirm();

?>

<?php $this->beginPage() ?>

<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <link rel="icon" href="<?= Yii::getAlias('@web') ?>/images/favicon.ico"/>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=768, user-scalable=no">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body>
<?php $this->beginBody() ?>

<div class="dark_wrapper load_page"></div>

<div class="popup_overlay"></div>

<div class="wrap">

    <?= $this->render('header.php'); ?>

    <div class="container">
        <div class="dashboard_name_user">
            Добро пожаловать,
            <strong><?= !Yii::$app->user->isGuest ? Yii::$app->user->getIdentity()->username : '' ?></strong>
        </div>

        <?= $this->render('@app/views/layouts/private_area_breadcrumbs') ?>

        <?php
        if (Yii::$app->session->hasFlash('error'))
            echo '<div class="alert alert-danger">' . Yii::$app->session->getFlash('error') . '</div>';

        if (Yii::$app->session->hasFlash('success'))
            echo '<div class="alert alert-success">' . Yii::$app->session->getFlash('success') . '</div>';
        ?>

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
