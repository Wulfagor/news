<?php

/*
 * This file is part of the Dektrium project
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\bootstrap\Nav;
use yii\helpers\Url;

?>

<?php

echo Nav::widget([
    'options' => [
        'class' => 'nav-tabs',
        'style' => 'margin-bottom: 15px',
    ],
    'items' => [
        [
            'label' => 'Highlights Press Releases',
            'url' => ['/press-releases/admin'],
            'visible' => Yii::$app->user->can('Superadmin'),
            'options' => [
                'class' => Yii::$app->controller->id == 'press-releases' ? 'active' : ''
            ]
        ],
        [
            'label' => 'Events',
            'url' => ['/events/admin'],
            'visible' => Yii::$app->user->can('Superadmin'),
            'options' => [
                'class' => Yii::$app->controller->id == 'events' ? 'active' : ''
            ]
        ],
        [
            'label' => 'Certifications',
            'url' => ['/certifications/admin'],
            'visible' => Yii::$app->user->can('Superadmin'),
            'options' => [
                'class' => Yii::$app->controller->id == 'certifications' ? 'active' : ''
            ]
        ],
        [
            'label' => 'Machines',
            'url' => ['/machines/admin'],
            'visible' => Yii::$app->user->can('Superadmin'),
            'options' => [
                'class' => Yii::$app->controller->id == 'machines' ? 'active' : ''
            ]
        ],
        [
            'label' => 'NOSO Bonding Technology',
            'url' => ['/noso/admin'],
            'visible' => Yii::$app->user->can('Superadmin'),
            'options' => [
                'class' => Yii::$app->controller->id == 'noso' ? 'active' : ''
            ]
        ],
        [
            'label' => 'Contact Form Data',
            'url' => ['/contact-form-data/index'],
            'visible' => Yii::$app->user->can('Superadmin'),
            'options' => [
                'class' => Yii::$app->controller->id == 'contact-form-data' ? 'active' : ''
            ]
        ],
        [
            'label' => 'Languages',
            'url' => ['/translatemanager/language/list'],
            'visible' => Yii::$app->user->can('Superadmin'),
            'options' => [
                'class' => Yii::$app->controller->id == 'language' ? 'active' : ''
            ]
        ],
        [
            'label' => Yii::t('user', 'Users'),
            'url' => ['/user/admin/index'],
            'visible' => Yii::$app->user->can('Superadmin'),
            'options' => [
                'class' => Yii::$app->controller->id == 'admin' ? 'active' : ''
            ]
        ]
    ],
]);

?>
