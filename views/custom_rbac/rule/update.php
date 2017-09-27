<?php

$this->title = 'Обновить правило';
$this->params['breadcrumbs'][] = ['label' => 'Правила', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="title_of_page"><?= $this->title ?></div>

<?= $this->render('_form', [
    'model' => $model,
]) ?>
