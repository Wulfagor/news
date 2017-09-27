<?php
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\helpers\Html;

$this->title = Yii::t('rbac', 'Roles');
$this->params['breadcrumbs'][] = $this->title;

?>

    <div class="title_of_page"><?= $this->title ?></div>

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right form-group">
            <?= Html::a('Создать роль', Url::to(['/rbac/role/create']), [
                'class' => 'btn btn-success'
            ]) ?>
        </div>
    </div>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $filterModel,
    'columns' => [
        [
            'attribute' => 'name',
            'header' => Yii::t('rbac', 'Name'),
            'options' => [
                'style' => 'width: 20%'
            ],
        ],
        [
            'attribute' => 'description',
            'header' => Yii::t('rbac', 'Description'),
            'options' => [
                'style' => 'width: 55%'
            ],
        ],
        [
            'attribute' => 'rule_name',
            'header' => Yii::t('rbac', 'Rule name'),
            'options' => [
                'style' => 'width: 20%'
            ],
        ],
        [
            'class' => ActionColumn::className(),
            'template' => '{update} {delete}',
            'urlCreator' => function ($action, $model) {
                return Url::to(['/rbac/role/' . $action, 'name' => $model['name']]);
            },
            'options' => [
                'style' => 'width: 5%'
            ],
        ]
    ],
]) ?>