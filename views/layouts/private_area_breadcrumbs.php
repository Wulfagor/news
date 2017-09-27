<?php

use yii\widgets\Breadcrumbs;
use yii\helpers\Url;

echo '<div>';
echo Breadcrumbs::widget([
    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    'homeLink' => [
        'label' => 'Private area',
        'url' => Url::to(['/private/index'])
    ]
]);
echo '</div>';

?>