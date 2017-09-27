<?php

namespace app\components;

use yii\base\Widget;
use yii\helpers\Html;
use dektrium\user\models\LoginForm;
use dektrium\user\controllers\SecurityController;

class AuthWidget extends Widget
{
    public function run()
    {
        $model = \Yii::createObject(LoginForm::className());

        return $this->render('auth', [
            'model'  => $model
        ]);
    }
}