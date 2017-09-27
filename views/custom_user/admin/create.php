<?php

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Nav;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;

$this->title = Yii::t('user', 'Create an user account');
$this->params['breadcrumbs'][] = ['label' => Yii::t('user', 'Manage users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<?php
if(Yii::$app->request->isAjax || Yii::$app->request->isPjax) {
    Pjax::begin([
        'id' => 'user-create-form-pjax',
        'enablePushState' => false
    ]);
}

?>

<div class="title_of_page"><?= $this->title ?></div>

<div class="row">

    <?php if(!Yii::$app->request->isAjax): ?>

    <div class="col-md-3">
        <div class="panel panel-default">
            <div class="panel-body">
                <?= Nav::widget([
                    'options' => [
                        'class' => 'nav-pills nav-stacked',
                    ],
                    'items' => [
                        ['label' => Yii::t('user', 'Account details'), 'url' => ['/user/admin/create']],
                        ['label' => Yii::t('user', 'Profile details'), 'options' => [
                            'class' => 'disabled',
                            'onclick' => 'return false;',
                        ]],
                        ['label' => Yii::t('user', 'Information'), 'options' => [
                            'class' => 'disabled',
                            'onclick' => 'return false;',
                        ]],
                    ],
                ]) ?>
            </div>
        </div>
    </div>

    <?php endif ?>

    <div class="col-md-<?= Yii::$app->request->isAjax ? 12 : 9 ?>">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="alert alert-info">
                    <?= Yii::t('user', 'Credentials will be sent to the user by email') ?>.
                    <?= Yii::t('user', 'A password will be generated automatically if not provided') ?>.
                </div>
                <?php $form = ActiveForm::begin([
                    'id' => 'user-create-form',
                    'layout' => 'horizontal',
                    'enableAjaxValidation' => true,
                    'enableClientValidation' => false,
                    'options' => [
                        'autocomplete' => 'off',
                        'data-pjax' => true
                    ],
                    'fieldConfig' => [
                        'horizontalCssClasses' => [
                            'wrapper' => 'col-sm-9',
                        ],
                    ],
                ]); ?>

                <?= $this->render('_user', ['form' => $form, 'user' => $user]) ?>

                <div class="form-group">
                    <div class="col-lg-offset-3 col-lg-9">
                        <?= Html::submitButton(Yii::t('user', 'Save'), [
                            'class' => 'btn btn-block btn-success'
                        ]) ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>

<?php

if(Yii::$app->request->isAjax || Yii::$app->request->isPjax) {
    Pjax::end();
}

?>