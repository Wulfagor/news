<?php
namespace app\controllers\custom_rbac;

use dektrium\user\filters\AccessRule;
use dektrium\user\Finder;
use app\models\custom_user\Profile;
use app\models\custom_user\User;
use app\models\custom_user\UserSearch;
use dektrium\user\Module;
use dektrium\user\traits\EventTrait;
use Yii;
use yii\base\ExitException;
use yii\base\Model;
use yii\base\Module as Module2;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;

use dektrium\rbac\controllers\RoleController as BaseRoleController;

class RoleController extends BaseRoleController
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
        $this->layout = '@app/views/layouts/private';
    }

}