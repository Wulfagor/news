<?php

use dektrium\user\widgets\Connect;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = 'Log in';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="one_page_header"
     style="background: url(<?= Yii::getAlias('@web') ?>/images/login_background.png) center center no-repeat; background-size: cover;">
    <div class="o_p_h_title"><?= $this->title ?></div>
</div>

<div class="container">
    <div class="row">
        <div class="one_page_body clearfix">
            <div class="col-lg-offset-3 col-md-offset-3 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <?php $form = ActiveForm::begin([
                    'id' => 'login-form',
                    'enableAjaxValidation'   => false,
                    'enableClientValidation' => false,
                    'fieldConfig' => [
                        'template' => "{label}\n{beginWrapper}\n{input}\n{endWrapper}",
                    ],
                ]) ?>

                <?= $form->field($model, 'login', ['inputOptions' => ['class' => 'form-control default_input']]) ?>

                <?= $form->field($model, 'password', ['inputOptions' => ['class' => 'form-control default_input']])->passwordInput() ?>

                <?= Html::submitButton('Log in', ['class' => 'btn f_a_submit']) ?>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
</div>
