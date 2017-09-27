<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\widgets\MaskedInput;

?>

<div id="form_register">

    <div class="f_a_close" onclick="show_form_register(); return false;"><span
            class="glyphicon glyphicon-remove"></span></div>

    <?php

    Pjax::begin([
        'id' => 'registration-form-pjax',
        'enablePushState' => false
    ]);

    echo '<div class="f_a_title">Sign up</div>';

    $form = ActiveForm::begin([
        'id' => 'registration-form-ajax',
        'action' => Url::to(['/user/registration/register']),
        'enableAjaxValidation' => false,
        'enableClientValidation' => false,
        'validateOnBlur' => false,
        'validateOnType' => false,
        'validateOnChange' => false,
        'options' => [
            'data-pjax' => true
        ]
    ]);

    echo $form->field($model, 'username', ['inputOptions' => ['class' => 'form-control default_input']]);
    echo $form->field($model, 'email', ['inputOptions' => ['class' => 'form-control default_input']]);
    echo $form->field($model, 'password', ['inputOptions' => ['class' => 'form-control default_input']])->passwordInput();
    echo $form->field($model, 'repeat_password', ['inputOptions' => ['class' => 'form-control default_input']])->passwordInput();

    echo Html::submitButton('Sign up', ['class' => 'btn f_a_submit']);

    echo '<div class="f_a_text">Already registered? Log in <a href="#" onclick="show_form_authorization(); return false;">here</a>.</div>';

    ActiveForm::end();

    if ($success)
        $this->registerJs(
            'show_form_register(true);'
        );

    Pjax::end();

    ?>

</div>