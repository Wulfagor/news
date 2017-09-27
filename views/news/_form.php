<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\jui\DatePicker;
use kartik\file\FileInput;
use yii\web\UploadedFile;
use yii\helpers\Url;
use kartik\widgets\SwitchInput;
use yii\helpers\FileHelper;

?>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">

                <?php $form = ActiveForm::begin([
                    'id' => 'news-create-form',
                    'layout' => 'horizontal',
                    'enableAjaxValidation' => false,
                    'enableClientValidation' => false,
                    'options' => [
                        'enctype' => 'multipart/form-data',
                        'autocomplete' => 'off',
                        'data-pjax' => true
                    ],
                    'fieldConfig' => [
                        'horizontalCssClasses' => [
                            'wrapper' => 'col-sm-9',
                        ],
                    ],
                ]); ?>

                <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'description_mini')->textarea(['rows' => 3]) ?>

                <?= $form->field($model, 'description')->textarea(['rows' => 3]) ?>

                <?php

                if (!$model->isNewRecord) {
                    echo $form->field($model, 'image_update_temp', [
                        'options' => [
                            'style' => 'dislay: none;'
                        ]
                    ])->hiddenInput([
                        'id' => 'image_update_temp'
                    ])->label(false);
                }

                ?>

                <?php

                $pluginOptions = [
                    'showUpload' => false,
                    'browseLabel' => '',
                    'removeLabel' => '',
                    'showPreview' => true,
                    'showCaption' => true,
                    'fileActionSettings' => [
                        'showUpload' => false,
                    ],
                ];

                $pluginEvents = [];

                if (!$model->isNewRecord && $model->image != NULL) {

                    $pluginOptions['initialPreview'] = Yii::getAlias('@web' . $model->image);
                    $pluginOptions['initialPreviewAsData'] = true;
                    $pluginOptions['initialCaption'] = basename(Yii::getAlias('@webroot' . $model->image));
                    $pluginOptions['initialPreviewConfig'] = [
                        [
                            'caption' => basename(Yii::getAlias('@webroot' . $model->image)),
                            'size' => filesize(Yii::getAlias('@webroot' . $model->image)),
                            'url' => false
                        ]
                    ];
                    $pluginOptions['initialPreviewShowDelete'] = false;
                    $pluginOptions['overwriteInitial'] = true;

                    $pluginEvents = [
                        "filecleared" => "function() { 
                            if(exists('#image_update_temp')) {
                                console.log('exists');
                                $('#image_update_temp').val('');
                            }    
                        }",
                    ];
                }

                echo $form->field($model, 'image')->widget(FileInput::classname(), [
                    'options' => [
                        'multiple' => false,
                        'accept' => 'image/*'
                    ],
                    'pluginOptions' => $pluginOptions,
                    'pluginEvents' => $pluginEvents
                ]);


                ?>

                <?= $form->field($model, 'status')->widget(SwitchInput::classname()); ?>

                <div class="form-group">
                    <div class="col-lg-offset-3 col-lg-9">
                        <?= Html::submitButton(
                            $model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
                            [
                                'class' => 'btn-block ' . ($model->isNewRecord ? 'btn btn-success' : 'btn btn-primary')
                            ]
                        ) ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
</div>

