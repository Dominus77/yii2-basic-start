<?php

namespace modules\admin\controllers;

use Yii;
use yii\web\Response;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use modules\admin\models\search\UserSearch;
use modules\admin\models\User;
use modules\admin\Module;

/**
 * Class UserController
 * @package modules\admin\controllers
 */
class UserController extends Controller
{
    /** @var  string|bool $jsFile */
    protected $jsFile;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [\modules\rbac\models\Permission::PERMISSION_MANAGER_USERS],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->processRegisterJs();
    }

    /**
     * Publish and register the required JS file
     */
    protected function processRegisterJs()
    {
        $this->jsFile = '@modules/users/views/ajax/ajax.js';
        $assetManager = Yii::$app->assetManager;
        $assetManager->publish($this->jsFile);
        $url = $assetManager->getPublishedUrl($this->jsFile);
        $this->view->registerJsFile($url,
            ['depends' => 'yii\web\JqueryAsset',] // depends
        );
    }

    /**
     * Lists all User models.
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $assignModel = new \modules\rbac\models\Assignment();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'assignModel' => $assignModel,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();
        $model->scenario = $model::SCENARIO_ADMIN_CREATE;

        if ($model->load(Yii::$app->request->post())) {
            $model->generateAuthKey();
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return Response
     * @throws NotFoundHttpException
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        /** @var object $identity */
        $identity = Yii::$app->user->identity;
        if ($model->id !== $identity->id || $model->isSuperAdmin($model->id))
            $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Action Generate new auth key
     * @param int|string $id
     * @return array|Response
     * @throws NotFoundHttpException
     */
    public function actionGenerateAuthKey($id)
    {
        $model = $this->processGenerateAuthKey($id);
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'success' => $model->auth_key,
            ];
        }
        return $this->redirect(['index']);
    }

    /**
     * Generate new auth key
     * @param int|string $id
     * @return User
     * @throws NotFoundHttpException
     */
    private function processGenerateAuthKey($id)
    {
        $model = $this->findModel($id);
        $model->generateAuthKey();
        $model->save(false);
        return $model;
    }

    /**
     * Change Status
     * @param int|string $id
     * @return array|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionStatus($id)
    {
        if ($model = $this->processChangeStatus($id)) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return [
                    'body' => $model->getStatusLabelName(),
                    'success' => true,
                ];
            }
        }
        return $this->redirect(['index']);
    }

    /**
     * @param int|string $id
     * @return bool|User|null
     * @throws NotFoundHttpException
     */
    private function processChangeStatus($id)
    {
        $model = $this->findModel($id);
        /** @var object $identity */
        $identity = Yii::$app->user->identity;
        if ($model->id !== $identity->id || $model->isSuperAdmin($model->id)) {
            $model->setStatus();
            $model->save(false);
            return $model;
        }
        return false;
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int|string $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Module::t('users', 'The requested page does not exist.'));
    }
}
