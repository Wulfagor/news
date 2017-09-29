<?php
namespace app\controllers\custom_user;

use dektrium\user\filters\AccessRule;
use dektrium\user\models\User;
use dektrium\user\models\Profile;
use dektrium\user\models\UserSearch;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Url;
use dektrium\rbac\models\Assignment;

use dektrium\user\controllers\AdminController as BaseAdminController;

class AdminController extends BaseAdminController
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
                        'roles' => ['Admin']
                    ],
                ],
            ],
        ];
    }

    public function init()
    {
        if (Yii::$app->user->isGuest)
            return $this->goHome();

        $this->layout = '@app/views/layouts/private';
    }

    public function actionIndex()
    {
        Url::remember('', 'actions-redirect');
        $searchModel = Yii::createObject(\app\models\custom_user\UserSearch::className());
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionCreate()
    {
        /** @var User $user */
        $user = Yii::createObject([
            'class' => User::className(),
            'scenario' => 'create',
        ]);
        $event = $this->getUserEvent($user);

        $this->performAjaxValidation($user);

        $this->trigger(self::EVENT_BEFORE_CREATE, $event);
        if ($user->load(Yii::$app->request->post()) && $user->create()) {
            Yii::$app->getSession()->setFlash('success', Yii::t('user', 'User has been created'));
            $this->trigger(self::EVENT_AFTER_CREATE, $event);



            if (Yii::$app->request->isAjax) {
                return $this->redirect([
                    'index'
                ]);
            } else {
                return $this->redirect([
                    'update',
                    'id' => $user->id
                ]);
            }
        }

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('create', [
                'user' => $user,
            ]);
        } else {
            return $this->render('create', [
                'user' => $user,
            ]);
        }
    }

    public function actionUpdate($id)
    {
        $type = Yii::$app->request->get('type');

        $user = $this->findModel($id);
        $user->scenario = 'update';
        $event = $this->getUserEvent($user);

        $this->performAjaxValidation($user);

        $this->trigger(self::EVENT_BEFORE_UPDATE, $event);

        if ($type == 'assignments') {
            $model = Yii::createObject([
                'class' => Assignment::className(),
                'user_id' => $id,
            ]);

            if ($model->load(\Yii::$app->request->post())) {
                $model->updateAssignments();

                if ($model->updated) {
                    Yii::$app->getSession()->setFlash('success', Yii::t('rbac', 'Assignments have been updated'));
                }

                if (Yii::$app->request->isAjax) {
                    return $this->redirect([
                        'index'
                    ]);
                }

            }

            if (Yii::$app->request->isAjax) {
                return $this->renderAjax($type, [
                    'model' => $model,
                    'user' => $user
                ]);
            }
        }

        if ($user->load(Yii::$app->request->post()) && $user->save()) {

            Yii::$app->getSession()->setFlash('success', Yii::t('user', 'Account details have been updated'));
            $this->trigger(self::EVENT_AFTER_UPDATE, $event);

            if (Yii::$app->request->isAjax) {
                return $this->redirect([
                    'index'
                ]);
            } else {
                return $this->refresh();
            }
        }

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax($type, [
                'user' => $user,
            ]);
        } else {
            return $this->render('_account', [
                'user' => $user,
            ]);
        }
    }

    public function actionUpdateProfile($id)
    {
        if ($id == 1)
            $this->redirect('/private/index');

        Url::remember('', 'actions-redirect');
        $user = $this->findModel($id);
        $profile = $user->profile;
        $user->profile->scenario = Profile::SCENARIO_REGISTER_ADMIN;

        if ($profile == null) {
            $profile = Yii::createObject(Profile::className());
            $profile->link('user', $user);
            $user->profile->scenario = Profile::SCENARIO_REGISTER_ADMIN;
        }

        if ($profile->load(Yii::$app->request->post())) {
            if ($profile->validate() && $profile->save()) {
                Yii::$app->getSession()->setFlash('success', Yii::t('user', 'Profile details have been updated'));
                return $this->refresh();
            }
        }

        return $this->render('_profile', [
            'user' => $user,
            'profile' => $profile
        ]);
    }

    public function actionDelete($id)
    {
        if ($id == Yii::$app->user->getId()) {
            Yii::$app->getSession()->setFlash('danger', Yii::t('user', 'You can not remove your own account'));
        } else {
            $model = $this->findModel($id);
            $event = $this->getUserEvent($model);
            $this->trigger(self::EVENT_BEFORE_DELETE, $event);
            $model->delete();
            $this->trigger(self::EVENT_AFTER_DELETE, $event);
            $auth = Yii::$app->authManager;
            $auth->revokeAll($id);
            Yii::$app->getSession()->setFlash('success', Yii::t('user', 'User has been deleted'));
        }

        return $this->redirect(['index']);
    }
}