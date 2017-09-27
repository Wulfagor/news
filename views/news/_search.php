<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use yii\widgets\Pjax;

$this->registerJs(
    '$("document").ready(function(){
        $("#news_search").on("pjax:end", function() {
        $.pjax.reload({container:"#news_list"});
    });
});'
);

$array_months = [
    1 => 'Gennaio',
    2 => 'Febbraio',
    3 => 'Marzo',
    4 => 'Aprile',
    5 => 'Maggio',
    6 => 'Giugno',
    7 => 'Luglio',
    8 => 'Agosto',
    9 => 'Settembre',
    10 => 'Ottobre',
    11 => 'Novembre',
    12 => 'Dicembre'
];

?>

<div class="news-search clearfix">

    <?php yii\widgets\Pjax::begin(['id' => 'news_search']) ?>

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'style' => 'margin-bottom: 20px;',
            'data-pjax' => true
        ]
    ]); ?>

    <div class="row">
        <div class="col-lg-offset-2 col-md-offset-2 col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="news_my_select_parent">
                <?= $form->field($model, 'year')->dropDownList($array_date, [
                    'prompt' => 'Anno',
                    'class' => 'news_my_select'
                ])->label(false); ?>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="news_my_select_parent">
                <?= $form->field($model, 'month')->dropDownList($array_months, [
                    'prompt' => 'Mese',
                    'class' => 'news_my_select'
                ])->label(false); ?>
            </div>
        </div>

        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
            <div class="form-group">
                <?= Html::submitButton('Cerca', ['class' => 'btn news_my_button']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

    <?php Pjax::end(); ?>

</div>
