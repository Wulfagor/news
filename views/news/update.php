<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;

$this->title = 'Edit news - ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'News', 'url' => ['/news/admin']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="title_of_page"><?= $this->title ?></div>

<?php

if(Yii::$app->request->isAjax || Yii::$app->request->isPjax) {
    Pjax::begin([
        'id' => 'news-update-form-pjax',
        'enablePushState' => false
    ]);
}

echo $this->render('_form', [
    'model' => $model,
]);

if(Yii::$app->request->isAjax || Yii::$app->request->isPjax) {
    Pjax::end();
}

?>
