<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/*
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var dektrium\user\models\RecoveryForm $model
 */

$this->title = 'Recupera password';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-recovery-request">

    <div class="page_back_image"
         style="background: url(<?= Yii::getAlias('@web') ?>/images/page_private_area_index.png) center center no-repeat; background-size: cover;">
    </div>

    <div class="container page_content clearfix">

        <div class="simply_text_bold text-uppercase title_space_down">Recupera password</div>

        <div class="simply_text">
            Se avete perso la vostra password, potete farne richiesta direttamente a
            <br><br>
            ANFAO (Associazione Nazionale Fabbricanti Articoli Ottici)
            <br>
            Via Petitti, 16 – 20149 Milano
            <br>
            Tel.: <a href="skype:02.32673673">02.32673673</a> – <a href="skype:02.3925315">02.3925315</a>
            <br>
            Fax: <a href="skype:02.324233">02.324233</a>
            <br>
            <a href="mailto:info@anfao.it">info@anfao.it</a>
        </div>

        <?php
        /*
        $form = ActiveForm::begin([
            'id' => 'password-recovery-form',
            'enableAjaxValidation' => true,
            'enableClientValidation' => false,
        ]);

        echo $form->field($model, 'email')->textInput(['autofocus' => true, 'class' => 'form-control private_input', 'placeholder' => 'Email'])->label(false);
        echo Html::submitButton(Yii::t('user', 'Continue'), ['class' => 'btn private_button']);

        ActiveForm::end();
        */
        ?>

    </div>
</div>
