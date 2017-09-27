<?php

$this->title = Yii::t('rbac', 'Update role');
$this->params['breadcrumbs'][] = ['label' => Yii::t('rbac', 'Roles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

    <div class="title_of_page"><?= $this->title ?></div>

<?= $this->render('_form', [
    'model' => $model,
]) ?>