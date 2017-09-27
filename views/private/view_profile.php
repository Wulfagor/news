<?php

use yii\helpers\Html;
use bigpaulie\fancybox\FancyBox;
use app\models\Pages;
use app\models\Documents;
use yii\helpers\ArrayHelper;
use app\models\PagesLinks;
use yii\helpers\Url;
use app\components\Dashboard;
use app\components\GreatController;

$this->title = 'View profile';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="title_of_page"><?= $this->title ?></div>
<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="simply_text">Username</div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="simply_text bold">
                <?= Yii::$app->user->identity->username ?>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="simply_text">Email</div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="simply_text bold">
                <?= Yii::$app->user->identity->email ?>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="simply_text">Password</div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="simply_text bold">
                **********
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="simply_button_group">
                <a href="<?= Url::to(['/private/change-profile']) ?>" class="btn btn-primary">Edit</a>
            </div>
        </div>
    </div>
</div>