<?php

$this->title = Yii::t('rbac', 'Update permission');
$this->params['breadcrumbs'][] = ['label' => Yii::t('rbac', 'Permissions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

    <div class="title_of_page"><?= $this->title ?></div>

<?= $this->render('_form', [
    'model' => $model,
]) ?>