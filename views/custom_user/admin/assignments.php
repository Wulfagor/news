<?php

/*
 * This file is part of the Dektrium project
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use dektrium\rbac\models\Assignment;
use kartik\select2\Select2;
use yii\bootstrap\Alert;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/**
 * @var yii\web\View 				$this
 * @var dektrium\user\models\User 	$user
 */

?>

<?php $this->beginContent('@dektrium/user/views/admin/ajax_update.php', ['user' => $user]) ?>

<?= yii\bootstrap\Alert::widget([
    'options' => [
        'class' => 'alert-info',
    ],
    'body' => Yii::t('user', 'You can assign multiple roles or permissions to user by using the form below'),
]) ?>

<?php $form = ActiveForm::begin([
    'action' => Url::to([
        '/user/admin/update',
        'id' => $model->user_id,
        'type' => 'assignments'
    ]),
    'enableAjaxValidation'   => true,
    'enableClientValidation' => false,
    'options' => [
        'autocomplete' => 'off',
        'data-pjax' => true
    ],
]) ?>

<?= Html::activeHiddenInput($model, 'user_id') ?>

<?= $form->field($model, 'items')->widget(Select2::className(), [
    'data' => $model->getAvailableItems(),
    'options' => [
        'id' => 'items',
        'multiple' => true
    ],
]) ?>

<?= Html::submitButton(Yii::t('rbac', 'Update assignments'), ['class' => 'btn btn-success btn-block']) ?>

<?php ActiveForm::end() ?>

<?php $this->endContent() ?>

