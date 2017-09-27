<?php

namespace app\components;

use yii;
use yii\base\Widget;
use yii\helpers\Html;
use dektrium\user\models\LoginForm;
use dektrium\user\controllers\SecurityController;
use app\models\custom_user\RegistrationForm;

class RegSuccessWidget extends Widget
{
    public function run()
    {
        return $this->render('reg_success');
    }
}