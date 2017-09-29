<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use dektrium\user\filters\AccessRule;

class PrivateController extends Controller
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
                        'allow' => false,
                        'roles' => ['?']
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ],
                ],
            ],
        ];
    }

    public function init()
    {
        $this->layout = 'private';
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionViewProfile()
    {
        return $this->render('view_profile');
    }

    public function actionChangeProfile()
    {
        $model_user = Yii::$app->user->identity;
        $post = Yii::$app->request->post();

        if (!empty($post)) {
            if ($model_user->load($post)) {
                if (!$model_user->save()) {
                    Yii::$app->session->setFlash('error', 'Can\'t change password');
                    return $this->render('change_profile', [
                        'model_user' => $model_user
                    ]);
                }
            }

            Yii::$app->session->setFlash('success', 'Your profile has been successfully updated');
            return $this->redirect('view-profile');
        }

        return $this->render('change_profile', [
            'model_user' => $model_user
        ]);
    }

}