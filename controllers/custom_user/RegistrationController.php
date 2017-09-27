<?php
namespace app\controllers\custom_user;

use app\models\custom_user\RegistrationForm;
use Yii;
use yii\filters\AccessControl;
use dektrium\user\filters\AccessRule;
use app\models\custom_user\Profile;

use dektrium\user\controllers\RegistrationController as BaseRegistrationController;

class RegistrationController extends BaseRegistrationController
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
                        'actions' => ['register'],
                        'roles' => ['?']
                    ],
                ]
            ],
        ];
    }

    public function actionRegister()
    {
        $success = false;

        $model = Yii::createObject(RegistrationForm::className());
        $event = $this->getFormEvent($model);

        $this->trigger(self::EVENT_BEFORE_REGISTER, $event);

        if ($model->load(Yii::$app->request->post())) {

            $user = $model->register();

            if ($user !== false) {
                $this->trigger(self::EVENT_AFTER_REGISTER, $event);

                $model = Yii::createObject(RegistrationForm::className());
                $success = true;

                $auth = Yii::$app->authManager;
                $role = $auth->getRole('User');
                $auth->assign($role, $user->id);
            }
        }

        if(!Yii::$app->request->isAjax && !Yii::$app->request->isPjax) {
            return $this->render('register', [
                'model' => $model,
                'success' => $success
            ]);
        } else {
            return $this->renderPartial('@app/components/views/reg', [
                'model' => $model,
                'success' => $success
            ]);
        }
    }

}