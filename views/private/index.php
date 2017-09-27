<?php

use yii\helpers\Html;
use bigpaulie\fancybox\FancyBox;
use app\models\Pages;
use app\models\Documents;
use yii\helpers\ArrayHelper;
use app\models\PagesLinks;
use yii\helpers\Url;
use app\components\Dashboard;
use app\components\GreatController;

$this->title = 'Private area';
$this->params['breadcrumbs'][] = (Yii::$app->user->isGuest ? '' : Yii::$app->user->identity->profile->name);
$Dashboard = new Dashboard();

?>
<div class="dashboard clearfix">
    <div class="row">
        <?php

        //get items by role
        $items = $Dashboard->getDashboardItems();

        if (!empty($items)) {
            foreach ($items as $key => $value) {
                echo '<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">';
                echo '<div class="dashboard_item">';
                echo '<div class="dashboard_item_icon ' . $value['icon'] . '"></div>';
                echo '<div class="dashboard_item_container">';
                echo '<h2>' . $value['name'] . '</h2>';
                echo '<p>' . $value['description'] . '</p>';
                echo '<a href="'.Url::to([$value['url']]).'"></a>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
        }
        ?>
    </div>
</div>