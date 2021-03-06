<?php

namespace app\controllers;

use Yii;
use app\models\CssSelector;
use app\models\CssSelectorSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\commands\tools\CurlClient;


/**
 * CssSelectorController implements the CRUD actions for CssSelector model.
 */
class CssSelectorController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout','index','create', 'update', 'view','delete'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['index','create', 'update', 'view','delete'],
                        'allow' => true,
                        'roles' => ['admin'],
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
     * Lists all CssSelector models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CssSelectorSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CssSelector model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new CssSelector model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($sourse = null,$news = null)
    {
        $model = new CssSelector();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'sourse' => $sourse,
                'news' => $news,
            ]);
        }
    }

    /**
     * Updates an existing CssSelector model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing CssSelector model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the CssSelector model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CssSelector the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CssSelector::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    
    public function actionTestCssSelector()
    {
        if(Yii::$app->request->isAjax){

            $error = [];
            $info = [];

            $post_data = Yii::$app->request->post();

            if (!isset($post_data)) {
                $error[] = 'The post data is not set';
                return $this->renderAjax('../site/_result', [
                    'error' => $error,
                ]);
            }

            if (!isset($post_data['selector'])) {
                $error[] = 'The css selector is not set';
                return $this->renderAjax('../site/_result', [
                    'error' => $error,
                ]);
            }

            $selector = CssSelector::findOne($post_data['selector']);

            if ($selector === null) {
                $error[] = 'The selector is not found';
                return $this->renderAjax('../site/_result', [
                    'error' => $error,
                ]);
            }

            $sourse = $selector->sourse;
            if ($sourse  !== null) {
                if ($sourse->url === null) {
                    $error[] = 'The sourse url is not found';
                    return $this->renderAjax('../site/_result', [
                        'error' => $error,
                    ]);
                }else{
                    $parse_url = $sourse->url;         
                }    
            }
            $news = $selector->newsSite;
            
            if ($news  !== null) {
                if (empty($post_data['testurl'])) {
                    $error[] = 'The test url is not set';
                    return $this->renderAjax('../site/_result', [
                        'error' => $error,
                    ]);
                }

                $parse_url = trim($post_data['testurl']);
            }

            if ($selector->type === null || $selector->name === null || $selector->selector === null) {
                $error[] = 'The type or name or selector is not set';
                return $this->renderAjax('../site/_result', [
                    'error' => $error,
                ]);
            }

            $attr = ($selector->attr !== null) ? $selector->attr : null;
                        
            $client = new CurlClient();

            $content = $client->parsePage($parse_url);

            $property = $client->parseProperty($content,$selector->type,$selector->selector,$parse_url,$attr);

            return $this->renderAjax('_result_test', [
                    'property' => $property
            ]);
            

        }
        else{
            Yii::$app->session->setFlash('error', 'Fuck, hands off of this page.');
            return $this->redirect(['site/index']);
        }
    }
}
