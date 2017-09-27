<?php

namespace app\components;

use yii;
use yii\base\Widget;
use app\models\custom_user\RegistrationForm;

class RegWidget extends Widget
{
    public function run()
    {
        $model = Yii::createObject(RegistrationForm::className());

        return $this->render('reg', [
            'model'  => $model,
            'success' => false
        ]);
    }
}