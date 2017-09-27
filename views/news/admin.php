<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use app\components\Great;
use kartik\widgets\SwitchInput;
use dektrium\rbac\models\Assignment;
use kartik\widgets\DatePicker;

$this->title = 'News';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="title_of_page"><?= $this->title ?></div>

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right form-group">
        <?= Html::a('Create news', Url::to(['/news/create']), [
            'class' => 'btn btn-success magic_dialog'
        ]) ?>
    </div>
</div>

<?php

Pjax::begin([
    'id' => 'news-admin-pjax',
    'enablePushState' => true,
    'scrollTo' => 1
]);

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        [
            'attribute' => 'id',
            'options' => [
                'width' => '5%'
            ]
        ],
        [
            'attribute' => 'title',
            'options' => [
                'width' => '15%'
            ]
        ],
        [
            'attribute' => 'description_mini',
            'content' => function ($data) {
                return Great::cut_text($data['description_mini']);
            },
            'options' => [
                'width' => '20%'
            ]
        ],
        [
            'attribute' => 'description',
            'content' => function ($data) {
                return Great::cut_text($data['description']);
            },
            'options' => [
                'width' => '20%'
            ]
        ],
        [
            'attribute' => 'created_at',
            'content' => function ($data) {
                return date('Y-m-d  H:i', $data->created_at);
            },
            'options' => [
                'width' => '20%'
            ],
            'filter' => DatePicker::widget([
                'model' => $searchModel,
                'attribute' => 'created_at_from',
                'attribute2' => 'created_at_to',
                'type' => DatePicker::TYPE_RANGE,
                'pluginOptions' => [
                    'autoclose'=>true,
                    'format' => 'yyyy-mm-dd',
                ],
                'options' => [
                    'class' => 'form-control',
                ],
            ])
        ],
        [
            'attribute' => 'status',
            'filter' => false,
            'content' => function ($data) {

                $action = Url::to(['/news/change-status']);

                return SwitchInput::widget([
                    'name' => 'status',
                    'value' => $data->status,
                    'pluginOptions' => [
                        'size' => 'small'
                    ],
                    'pluginEvents' => [
                        "switchChange.bootstrapSwitch" => "function(even, state) {
                            $.ajax({
                                url: '$action',
                                method: 'post',
                                data: {id: $data->id, state: state},
                                dataType: 'json',
                                success: function(response) {
                                    $.pjax.reload('#news-admin-pjax');
                                },
                                error: function(response) {
                                    if(typeof response == 'object') {
                                        if(response.responseText)
                                            bootbox.alert({
                                                message: response.responseText,
                                                callback: function() {
                                                    $.pjax.reload('#news-admin-pjax');
                                                }
                                            });
                                        else {
                                            bootbox.alert({
                                                message: 'Sorry, this action can not executed.',
                                                callback: function() {
                                                    $.pjax.reload('#news-admin-pjax');
                                                }
                                            });
                                        }
                                    } else
                                        bootbox.alert({
                                            message: 'Sorry, this action can not executed.',
                                            callback: function() {
                                                    $.pjax.reload('#news-admin-pjax');
                                                }
                                        });
                                }
                            });
                        }",
                    ]
                ]);
            },
            'options' => [
                'width' => '10%'
            ]
        ],
        [
            'header' => 'Edit',
            'class' => 'yii\grid\ActionColumn',
            'template' => '{view}{edit}{delete}',
            'buttons' => [
                'view' => function ($url, $model) {
                    if($model->status)
                        return Html::a('View', Url::to([
                            '/news/view',
                            'id' => $model->id
                        ]), [
                            'title' => Yii::t('app', 'View'),
                            'target' => '_blank',
                            'data-pjax' => 0,
                            'class' => 'btn-block'
                        ]);
                },
                'edit' => function ($url, $model) {

                    $show = false;
                    $Assignment = new Assignment([
                        'user_id' => Yii::$app->user->id
                    ]);
                    $role_items = $Assignment->items;

                    if(in_array('ContentManager', $role_items) && ($model->user_id == Yii::$app->user->id))
                        $show = true;

                    if(in_array('Admin', $role_items))
                        $show = true;

                    if($show) {
                        return Html::a('Edit', Url::to([
                            '/news/update',
                            'id' => $model->id
                        ]), [
                            'title' => Yii::t('app', 'Edit'),
                            'class' => 'magic_dialog btn-block',
                            'data-pjax' => 0
                        ]);
                    } else
                        return false;
                },
                'delete' => function ($url, $model) {

                    $show = false;
                    $Assignment = new Assignment([
                        'user_id' => Yii::$app->user->id
                    ]);
                    $role_items = $Assignment->items;

                    if(in_array('ContentManager', $role_items) && ($model->user_id == Yii::$app->user->id))
                        $show = true;

                    if(in_array('Admin', $role_items))
                        $show = true;

                    if($show) {
                        return Html::a('Delete', Url::to([
                            '/news/delete',
                            'id' => $model->id
                        ]), [
                            'title' => Yii::t('app', 'Delete'),
                            'data-confirm' => 'Are you sure?',
                            'class' => 'btn-block',
                            'data-pjax' => 0
                        ]);
                    } else
                        return false;
                },
            ],
            'options' => [
                'width' => '10%'
            ]
        ],
    ],
]);

Pjax::end();

?>
