<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

?>

<div id="form_authorization">

    <div class="f_a_close" onclick="show_form_authorization(); return false;"><span class="glyphicon glyphicon-remove"></span></div>

    <div class="f_a_title">Log in</div>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form-ajax',
        'action' => Url::to(['/user/security/login']),
        'enableAjaxValidation' => true,
        'enableClientValidation' => false,
        'validateOnBlur' => false,
        'validateOnType' => false,
        'validateOnChange' => false,
    ]) ?>

    <?= $form->field($model, 'login', ['inputOptions' => ['class' => 'form-control default_input']]) ?>

    <?= $form->field($model, 'password', ['inputOptions' => ['class' => 'form-control default_input']])->passwordInput() ?>

    <?php
    /*
    echo '<div class="f_a_recovery_password">';
    echo Html::a('Забыли пароль?', '#', //Url::to(['/user/recovery/request']
        [
            'tabindex' => '3',
        ]);
    echo '</div>';
    */
    ?>

    <?= Html::submitButton('Log in', ['class' => 'btn f_a_submit']) ?>

    <?php ActiveForm::end(); ?>

    <?php
    ?>
    <div class="f_a_text">Don't have account? Start <a href="#" onclick="show_form_register(); return false;">here</a>.</div>

    <?php
    ?>

</div>