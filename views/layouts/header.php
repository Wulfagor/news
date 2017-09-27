<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Url;

?>

<?
NavBar::begin([
    'brandLabel' => 'Website',
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar-inverse navbar-fixed-top',
    ],
]);
echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'items' => [
        ['label' => 'Home', 'url' => ['/site/index']],
        ['label' => 'Sign up', 'url' => Url::home(), 'options' => [
            'id' => 'menu_item_register',
            'onclick' => 'show_form_register(); return false;'
        ],
            'visible' => Yii::$app->user->isGuest ? true : false,
        ],
        ['label' => 'Log in', 'url' => Url::home(), 'options' => [
            'id' => 'menu_item_authorization',
            'onclick' => 'show_form_authorization(); return false;'
        ],
            'visible' => Yii::$app->user->isGuest ? true : false,
        ],
        ['label' => 'Private area', 'url' => ['/private/index'],
            'visible' => !Yii::$app->user->isGuest ? true : false,
        ],
        ['label' => 'Log out', 'url' => ['/user/security/logout'],
            'visible' => !Yii::$app->user->isGuest ? true : false,
        ]
    ],
]);
NavBar::end();
?>
