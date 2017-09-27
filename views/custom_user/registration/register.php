<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\widgets\MaskedInput;

$this->title = 'Sign up';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="one_page_header"
     style="background: url(<?= Yii::getAlias('@web') ?>/images/login_background.png) center center no-repeat; background-size: cover;">
    <div class="o_p_h_title"><?= $this->title ?></div>
</div>

<div class="container">
    <div class="one_page_body clearfix">
        <div class="row">
            <div class="col-lg-offset-3 col-md-offset-3 col-lg-6 col-md-6 col-sm-12 col-xs-12">

                <?php

                if ($success) {
                    echo '<div class="alert alert-success">';
                    echo nl2br(Html::encode('You have successfully registered! Welcome on website!'));
                    echo '</div>';
                }

                $form = ActiveForm::begin([
                    'id' => 'registration-form',
                    'enableAjaxValidation' => false,
                    'enableClientValidation' => false,
                    'fieldConfig' => [
                        'template' => "{label}\n{beginWrapper}\n{input}\n{endWrapper}",
                    ],
                ]);

                echo $form->field($model, 'username', ['inputOptions' => ['class' => 'form-control default_input']]);
                echo $form->field($model, 'email', ['inputOptions' => ['class' => 'form-control default_input']]);
                echo $form->field($model, 'password', ['inputOptions' => ['class' => 'form-control default_input']])->passwordInput();
                echo $form->field($model, 'repeat_password', ['inputOptions' => ['class' => 'form-control default_input']])->passwordInput();

                echo Html::submitButton(Yii::t('user', 'Sign up'), ['class' => 'btn f_a_submit']);

                ActiveForm::end();

                ?>

            </div>
        </div>
    </div>
</div>

