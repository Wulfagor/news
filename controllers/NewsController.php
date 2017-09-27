<?php

namespace app\controllers;

use Yii;
use app\models\News;
use app\models\NewsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\Pagination;
use yii\helpers\Url;
use dektrium\user\filters\AccessRule;
use yii\filters\AccessControl;
use yii\web\UploadedFile;
use app\components\Great;
use yii\web\HttpException;
use dektrium\rbac\models\Assignment;

/**
 * NewsController implements the CRUD actions for News model.
 */
class NewsController extends Controller
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
                        'actions' => [
                            'admin',
                            'create',
                            'update',
                            'change-status',
                            'delete'
                        ],
                        'roles' => ['?']
                    ],
                    [
                        'allow' => true,
                        'actions' => ['view'],
                        'roles' => ['@']
                    ],
                    [
                        'allow' => true,
                        'roles' => [
                            'Admin',
                            'ContentManager'
                        ]
                    ],
                ],
            ]
        ];
    }

    public function actionAdmin()
    {
        $this->layout = 'private';

        $searchModel = new NewsSearch();
        $get_params = Yii::$app->request->queryParams;
        if (isset($get_params['NewsSearch']['created_at']) && !empty($get_params['NewsSearch']['created_at'])) {
            $obj_date = \DateTime::createFromFormat('d F Y', (string)$get_params['NewsSearch']['created_at']);
            $get_params['NewsSearch']['created_at'] = $obj_date->format('Y-m-d H:i:s');
        }
        $dataProvider = $searchModel->search($get_params);


        return $this->render('admin', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'role_items' => $role_items
        ]);
    }

    public function actionView($id)
    {
        if (empty($id))
            return $this->goHome();

        $this->layout = 'main';

        $model = News::find()
            ->where([
                'id' => $id,
                'status' => 1
            ])
            ->one();

        if (!$model)
            return $this->goHome();

        return $this->render('view', [
            'model' => $model
        ]);
    }

    public function actionChangeStatus()
    {
        if (!Yii::$app->request->isAjax)
            return $this->goHome();

        $post = Yii::$app->request->post();
        if (!isset($post['id']) || !isset($post['state']) || is_null($post['id']))
            throw new HttpException(500, 'Not enough data.');

        $news = $this->findModel($post['id']);

        if (!$news)
            throw new HttpException(500, 'Data does not exist.');

        if (is_null($post['state'])) {
            if ($news->status)
                $new_state = 0;
            else
                $new_state = 1;
        } else {
            if ($post['state'] == 'true')
                $new_state = 1;
            else
                $new_state = 0;
        }

        $news->status = $new_state;

        if ($news->validate() && $news->save())
            return true;
        else
            throw new HttpException(500, json_encode($news->getErrors()));

    }

    public function actionCreate()
    {
        $this->layout = 'private';

        $model = new News();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $model->image = Great::processFileModel($model, 'image');
            $model->link('user', Yii::$app->user->identity);

            if ($model->save()) {
                Yii::$app->getSession()->setFlash('success', 'News has been created');
                return $this->redirect(['admin']);
            }
        }

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }

    }

    public function actionUpdate($id = NULL)
    {
        $this->layout = 'private';

        $model = $this->findModel($id);

        $Assignment = new Assignment([
            'user_id' => Yii::$app->user->id
        ]);

        $role_items = $Assignment->items;
        $allow = false;

        if(in_array('ContentManager', $role_items)) {
            if($model->user_id == Yii::$app->user->id)
                $allow = true;
        }

        if(in_array('Admin', $role_items))
            $allow = true;

        if(!$allow)
            return $this->redirect(['admin']);

        if($model->image != NULL)
            $model->image_update_temp = $model->image;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $model->image = Great::processFileModel($model, 'image', 'image_update_temp');

            if ($model->save()) {
                Yii::$app->getSession()->setFlash('success', 'News has been updated');
                return $this->redirect(['admin']);
            }
        }

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionDelete($id)
    {
        $this->layout = 'private';

        $model = $this->findModel($id);
        if ($model->image != null && file_exists(Yii::getAlias('@webroot' . $model->image)))
            unlink(Yii::getAlias('@webroot' . $model->image));

        if ($model->delete())
            Yii::$app->getSession()->setFlash('success', 'News has been deleted');
        else
            Yii::$app->getSession()->setFlash('error', 'Can not delete news');

        return $this->redirect(['admin']);
    }

    protected function findModel($id)
    {
        if (($model = News::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
