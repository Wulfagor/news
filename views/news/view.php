<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

$this->title = $model->title;
?>


<?php

$image_url = Yii::getAlias('@web') . '/images/no-photo.png';

if ($model->image != null && file_exists(Yii::getAlias('@webroot' . $model->image)))
    $image_url = $model->image;

?>

<div class="one_page_header"
     style="background: url(<?= $image_url ?>) center center no-repeat; background-size: cover;">
    <a href="<?= Url::to(['/site/index']) ?>" class="o_p_h_navigation">News<span></span></a>
    <div class="o_p_h_title"><?= $model->title ?></div>
</div>
    <div class="o_p_news_time">
        <span class="glyphicon glyphicon-time"></span><?= date("d F Y", $model->created_at) ?>
    </div>
    <div class="o_p_news_text">
        <?= $model->description ?>
    </div>
