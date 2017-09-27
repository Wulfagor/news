<?php
namespace app\controllers\custom_user;

use yii\filters\AccessControl;
use dektrium\user\Finder;
use dektrium\user\models\Account;
use dektrium\user\models\LoginForm;
use yii\base\Model;
use yii\helpers\Url;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\authclient\ClientInterface;
use yii\web\Response;
use yii\widgets\ActiveForm;
use dektrium\user\filters\AccessRule;

use dektrium\user\controllers\SecurityController as BaseSecurityController;

class SecurityController extends BaseSecurityController
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'ruleConfig' => [
                    'class' => AccessRule::className(),
                ],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['login'],
                        'roles' => ['?']
                    ],
                    [
                        'allow' => true,
                        'actions' => ['logout'],
                        'roles' => ['@']
                    ],
                ]
            ],
        ];
    }

    public function actionLogin()
    {
        $model = \Yii::createObject(LoginForm::className());
        $event = $this->getFormEvent($model);

        //print_r($event);
        //exit;

        $this->performAjaxValidation($model);

        $this->trigger(self::EVENT_BEFORE_LOGIN, $event);

        if ($model->load(\Yii::$app->getRequest()->post()) && $model->login()) {
            $this->trigger(self::EVENT_AFTER_LOGIN, $event);

            $previous_url = Url::previous('current');
            if (!empty($previous_url))
                return $this->redirect($previous_url);
            else
                return $this->goHome();
        }

        return $this->render('login', [
            'model' => $model,
            'module' => $this->module,
        ]);
    }

    public function actionLogout()
    {
        $previous_url = Url::previous('current');
        $event = $this->getUserEvent(\Yii::$app->user->identity);

        $this->trigger(self::EVENT_BEFORE_LOGOUT, $event);

        \Yii::$app->getUser()->logout();

        $this->trigger(self::EVENT_AFTER_LOGOUT, $event);

        if (!empty($previous_url))
            return $this->redirect($previous_url);
        else
            return $this->goHome();
    }
}