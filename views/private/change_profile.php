<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\models\Pages;
use app\models\Documents;
use yii\helpers\ArrayHelper;
use app\models\PagesLinks;
use yii\helpers\Url;
use app\components\Dashboard;
use app\components\GreatController;
use yii\widgets\MaskedInput;

$this->title = 'Edit profile';
$this->params['breadcrumbs'][] = ['label' => 'View profile', 'url' => ['/private/view-profile']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="title_of_page"><?= $this->title ?></div>
<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <?php $form_profile = ActiveForm::begin([
            'options' => ['enctype' => 'multipart/form-data']
        ]); ?>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="simply_text">Username</div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <?= $form_profile->field($model_user, 'username')->textInput(
                [
                    'maxlength' => true,
                    'class' => 'form-control default_input',
                    'style' => 'margin: 0;'
                ]
            )->label(false) ?>
        </div>
        <div class="clearfix"></div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="simply_button_group">
                <?= Html::submitButton($model_user->isNewRecord ? 'Create' : 'Change', ['class' => $model_profile->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <?php $form_user = ActiveForm::begin([
            'options' => ['enctype' => 'multipart/form-data']
        ]); ?>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="simply_text">Password</div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <?= $form_user->field($model_user, 'password')->textInput([
                'maxlength' => true,
                'class' => 'form-control default_input',
                'style' => 'margin: 0;'
            ])->label(false) ?>
        </div>
        <div class="clearfix"></div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="simply_button_group">
                <?= Html::submitButton($model_user->isNewRecord ? 'Create' : 'Change', ['class' => $model_user->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>