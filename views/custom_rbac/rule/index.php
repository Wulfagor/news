<?php
use kartik\select2\Select2;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\Pjax;
use yii\helpers\Html;

$this->title = 'Правила';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="title_of_page"><?= $this->title ?></div>

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right form-group">
        <?= Html::a('Создать новое правило', Url::to(['/rbac/rule/create']), [
            'class' => 'btn btn-success'
        ]) ?>
    </div>
</div>

<?php Pjax::begin() ?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel'  => $searchModel,
    'layout'       => "{items}\n{pager}",
    'columns'      => [
        [
            'attribute' => 'name',
            'label'     => Yii::t('rbac', 'Name'),
            'options'   => [
                'style' => 'width: 20%'
            ],
            'filter' => Select2::widget([
                'model'     => $searchModel,
                'attribute' => 'name',
                'options'   => [
                    'placeholder' => Yii::t('rbac', 'Select rule'),
                ],
                'pluginOptions' => [
                    'ajax' => [
                        'url'      => Url::to(['search']),
                        'dataType' => 'json',
                        'data'     => new JsExpression('function(params) { return {q:params.term}; }')
                    ],
                    'allowClear' => true,
                    
                ],
            ]),
        ],
        [
            'attribute' => 'class',
            'label'     => Yii::t('rbac', 'Class'),
            'value'     => function ($row) {
                $rule = unserialize($row['data']);

                return get_class($rule);
            },
            'options'   => [
                'style' => 'width: 20%'
            ],
        ],
        [
            'attribute' => 'created_at',
            'label'     => Yii::t('rbac', 'Created at'),
            'format'    => 'datetime',
            'options'   => [
                'style' => 'width: 20%'
            ],
        ],
        [
            'attribute' => 'updated_at',
            'label'     => Yii::t('rbac', 'Updated at'),
            'format'    => 'datetime',
            'options'   => [
                'style' => 'width: 20%'
            ],
        ],
        [
            'class'      => ActionColumn::className(),
            'template'   => '{update} {delete}',
            'urlCreator' => function ($action, $model) {
                return Url::to(['/rbac/rule/' . $action, 'name' => $model['name']]);
            },
            'options'   => [
                'style' => 'width: 5%'
            ],
        ]
    ],
]) ?>

<?php Pjax::end() ?>
