<?php

use dektrium\user\models\User;
use yii\bootstrap\Nav;
use yii\web\View;
use yii\widgets\Pjax;
use dektrium\rbac\widgets\Assignments;

if (Yii::$app->request->isAjax || Yii::$app->request->isPjax) {
    Pjax::begin([
        'id' => 'user-forms-pjax',
        'enablePushState' => false
    ]);
}

$this->title = Yii::t('user', 'Update user: ' . ' (id' . $user->id . ')');

?>

<div class="title_of_page"><?= $this->title ?></div>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <?= $content ?>
            </div>
        </div>
    </div>
</div>

<?php

if (Yii::$app->request->isAjax || Yii::$app->request->isPjax) {
    Pjax::end();
}

?>
