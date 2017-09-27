<?php

use yii\grid\GridView;
use yii\helpers\Html;
use kartik\widgets\DatePicker;
use yii\web\View;
use yii\widgets\Pjax;
use yii\helpers\Url;

$this->title = Yii::t('user', 'Manage users');
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="title_of_page"><?= $this->title ?></div>

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right form-group">
        <?php

        echo Html::a('Create user', Url::to(['/user/admin/create']), [
            'class' => 'btn btn-success magic_dialog'
        ]);

        ?>
    </div>
</div>

<?php Pjax::begin([
    'id' => 'user-admin-pjax',
    'enablePushState' => true,
    'scrollTo' => 1
]) ?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        'id',
        'username',
        'email:email',
        [
            'attribute' => 'created_at',
            'value' => function ($model) {
                if(!is_null($model->created_at))
                    return date('Y-m-d H:i', $model->created_at);
                else
                    return $model->created_at;
            },
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
            'attribute' => 'last_login_at',
            'value' => function ($model) {
                if(!is_null($model->last_login_at))
                    return date('Y-m-d H:i', $model->last_login_at);
                else
                    return $model->last_login_at;
            },
            'filter' => DatePicker::widget([
                'model' => $searchModel,
                'attribute' => 'last_login_at_from',
                'attribute2' => 'last_login_at_to',
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
            'header' => Yii::t('user', 'Confirmation'),
            'value' => function ($model) {
                if ($model->isConfirmed) {
                    return '<div class="text-center"><span class="text-success">' . Yii::t('user', 'Confirmed') . '</span></div>';
                } else {
                    return Html::a(Yii::t('user', 'Confirm'), ['confirm', 'id' => $model->id], [
                        'class' => 'btn btn-xs btn-success btn-block',
                        'data-method' => 'post',
                        'data-confirm' => Yii::t('user', 'Are you sure you want to confirm this user?'),
                    ]);
                }
            },
            'format' => 'raw',
            'visible' => Yii::$app->getModule('user')->enableConfirmation,
        ],
        [
            'header' => 'Edit',
            'class' => 'yii\grid\ActionColumn',
            'template' => '{account}{assignments}{delete}',
            'buttons' => [
                'account' => function ($url, $model) {
                    return Html::a('Account', Url::to([
                        '/user/admin/update',
                        'type' => 'account',
                        'id' => $model->id
                    ]), [
                        'title' => Yii::t('app', 'Edit account'),
                        'class' => 'magic_dialog btn-block',
                        'data-pjax' => 0
                    ]);
                },
                'assignments' => function ($url, $model) {
                    return Html::a('Assignments', Url::to([
                        '/user/admin/update',
                        'type' => 'assignments',
                        'id' => $model->id
                    ]), [
                        'title' => Yii::t('app', 'Edit assignments'),
                        'class' => 'magic_dialog btn-block',
                        'data-pjax' => 0
                    ]);
                },
                'delete' => function ($url, $model) {
                    return Html::a('Delete', Url::to([
                        '/user/admin/delete',
                        'id' => $model->id
                    ]), [
                        'title' => Yii::t('app', 'Delete'),
                        'data-confirm' => 'Are you sure?',
                        'class' => 'btn-block',
                        'data-pjax' => 0
                    ]);
                },
            ]
        ],
    ],
]); ?>

<?php Pjax::end() ?>

