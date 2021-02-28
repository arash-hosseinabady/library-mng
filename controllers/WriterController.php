<?php

namespace app\controllers;

use app\models\User;
use Yii;
use app\models\Writer;
use app\models\WriterSearch;
use yii\db\Exception;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * WriterController implements the CRUD actions for Writer model.
 */
class WriterController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'create', 'update', 'view', 'delete'],
                'rules' => [
                    [
                        'actions' => ['index', 'create', 'update', 'view', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Writer models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new WriterSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Writer model.
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
     * Creates a new Writer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @throws \Throwable
     */
    public function actionCreate()
    {
        $model = new Writer();
        $modelUser = new User(['scenario'=>'newUser']);

        if ($model->load(Yii::$app->request->post()) && $modelUser->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if (!$modelUser->save()) {
                    throw new Exception(Yii::t('app', 'Error in creation writer'));
                }
                $model->user_id = $modelUser->id;
                if (!$model->save()) {
                    throw new Exception(Yii::t('app', 'Error in creation writer'));
                }

                $transaction->commit();

                return $this->redirect('index');
            } catch (\Exception $e) {
                $transaction->rollBack();
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('create', [
            'model' => $model,
            'modelUser' => $modelUser,
        ]);
    }

    /**
     * Updates an existing Writer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelUser = User::findOne(['id' => $model->user_id]);

        if ($model->load(Yii::$app->request->post()) && $modelUser->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if (!$modelUser->save()) {
                    throw new Exception(Yii::t('app', 'Error in change password for writer'));
                }
                $model->user_id = $modelUser->id;
                if (!$model->save()) {
                    throw new Exception(Yii::t('app', 'Error in change password for writer'));
                }

                $transaction->commit();

                return $this->redirect('index');
            } catch (\Exception $e) {
                $transaction->rollBack();
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            $modelUser->load(Yii::$app->request->post());
//            $modelUser->setPassword($modelUser->password);
//            return $this->redirect(['view', 'id' => $model->id]);
//        }

        return $this->render('update', [
            'model' => $model,
            'modelUser' => $modelUser,
        ]);
    }

    /**
     * Deletes an existing Writer model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Writer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Writer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Writer::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
