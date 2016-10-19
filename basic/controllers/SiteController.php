<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use app\models\LoginForm;
use app\models\Sourse;
use app\models\Subject;
use app\models\News;
use app\models\NewsSites;
use app\models\Post;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout','index','login','load-details-subject','processed-subject','reload-left-area','processed-news','create-news'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['login'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['index','load-details-subject','processed-subject','reload-left-area','processed-news','create-news'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $query_subject = Subject::find()->joinWith(['news.smi','firstNews'])->where([
                'and',
                    [
                        'subject.status' => Subject::STATUS_SPIDER
                    ],
                    [
                        'news_sites.fulltext' => NewsSites::FULLTEXT_YES
                    ],
                    [
                        'between', 'subject.created_at', strtotime(date("Y-m-d")), time() 
                    ]
            ])->orderBy(['subject.created_at' => SORT_DESC]);
        $subjects = $query_subject->limit(1000)->all();
        $count_subject = count($subjects);
        
        $count_rss_news = News::find()->joinWith('sourse')->where(
            [
                'and',
                    [
                        'news.status' => News::STATUS_CRAWLER
                    ],
                    [
                        'sourse.type' => Sourse::TYPE_RSS
                    ]
            ])->count();

        $count_mail_news = News::find()->joinWith('sourse')->where(
            [
                'and',
                    [
                        'news.status' => News::STATUS_CRAWLER
                    ],
                    [
                        'sourse.type' => Sourse::TYPE_MAIL
                    ]
            ])->count();

        return $this->render('index',[
            'subjects' => $subjects,
            'count_subject' => $count_subject,
            'count_rss_news' => $count_rss_news,
            'count_mail_news' => $count_mail_news,
            ]);

    }

    


    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionLoadDetailsSubject()
    {
        if(Yii::$app->request->isAjax){

            $error = [];
            $info = [];

            $post_data = Yii::$app->request->post();

            if (!isset($post_data)) {
                $error[] = 'The post data is not set';
                return $this->renderAjax('_result', [
                    'error' => $error,
                ]);
            }

            $subject = Subject::findOne($post_data['subject']);

            if ($subject === null) {
                $error[] = 'The subject is not found';
                return $this->renderAjax('_result', [
                    'error' => $error,
                ]);
            }
            

            return $this->renderAjax('subject/_single_details', [
                    'subject' => $subject,
                    'keywords_stats' => $subject->phraseStats(),
            ]);
            

        }
        else{
            Yii::$app->session->setFlash('error', 'Fuck, hands off of this page.');
            return $this->redirect(['site/index']);
        }
    }

    public function actionProcessedSubject()
    {
        if(Yii::$app->request->isAjax){

            $error = [];
            $info = [];

            $post_data = Yii::$app->request->post();

            if (!isset($post_data)) {
                $error[] = 'The post data is not set';
                return $this->renderAjax('_result', [
                    'error' => $error,
                ]);
            }

            $subject = Subject::findOne($post_data['subject']);

            if ($subject === null) {
                $error[] = 'The subject is not found';
                return $this->renderAjax('_result', [
                    'error' => $error,
                ]);
            }

            $subject->status = Subject::STATUS_PROCESSED;
            if ($subject->save()) {
                return 'ok';
            }else{
                foreach ($subject->getErrors() as $er) {
                    $error[] = $er[0];
                }
                return $this->renderAjax('_error', [
                    'error' => $error,
                ]);
            }
            

        }
        else{
            Yii::$app->session->setFlash('error', 'Fuck, hands off of this page.');
            return $this->redirect(['site/index']);
        }
    }
    
    public function actionProcessedNews()
    {
        if(Yii::$app->request->isAjax){

            $error = [];
            $info = [];

            $post_data = Yii::$app->request->post();

            if (!isset($post_data)) {
                $error[] = 'The post data is not set';
                return $this->renderAjax('_result', [
                    'error' => $error,
                ]);
            }

            $news = News::findOne($post_data['news']);

            if ($news === null) {
                $error[] = 'The news is not found';
                return $this->renderAjax('_result', [
                    'error' => $error,
                ]);
            }

            $news->status = News::STATUS_PROCESSED;
            if ($news->save()) {
                return 'ok';
            }else{
                foreach ($news->getErrors() as $er) {
                    $error[] = $er[0];
                }
                return $this->renderAjax('_error', [
                    'error' => $error,
                ]);
            }
            

        }
        else{
            Yii::$app->session->setFlash('error', 'Fuck, hands off of this page.');
            return $this->redirect(['site/index']);
        }
    }

    public function actionReloadLeftArea()
    {
        if(Yii::$app->request->isAjax){

            $error = [];
            $info = [];

            $post_data = Yii::$app->request->post();

            if (!isset($post_data)) {
                $error[] = 'The post data is not set';
                return $this->renderAjax('_result', [
                    'error' => $error,
                ]);
            }

            
            if (!isset($post_data['type'])) {
                $error[] = 'The type is not set';
                return $this->renderAjax('_result', [
                    'error' => $error,
                ]);
            }
            
            
            if ($post_data['type'] === 'subject') {
                $query_subject = Subject::find()->where(['status' => Subject::STATUS_SPIDER])->orderBy(['created_at' => SORT_DESC]);
                $count_subject = $query_subject->count();
                $subjects = $query_subject->limit(50)->all();
                return $this->renderAjax('subject/_list', [
                    'subjects' => $subjects,
                    
                ]);
            }

            if ($post_data['type'] === 'rss') {
                $rss = Sourse::find()->with('crawlerNews')->where(
                    [
                        'and',
                            ['type' => Sourse::TYPE_RSS],
                            ['status' => Sourse::STATUS_ACTIVE]            
                    ]
                )->all();
                return $this->renderAjax('rss/_list', [
                    'rss' => $rss,
                    
                ]);
            }

            if ($post_data['type'] === 'mail') {
                $mails = Sourse::find()->with('crawlerNews')->where(
                    [
                        'and',
                            ['type' => Sourse::TYPE_MAIL],
                            ['status' => Sourse::STATUS_ACTIVE]            
                    ]
                )->all();
                return $this->renderAjax('mail/_list', [
                    'mails' => $mails,
                    
                ]);
            }
        }
        else{
            Yii::$app->session->setFlash('error', 'Fuck, hands off of this page.');
            return $this->redirect(['site/index']);
        }
    }
    public function actionLoadDetailsRss()
    {
        if(Yii::$app->request->isAjax){

            $error = [];
            $info = [];

            $post_data = Yii::$app->request->post();

            if (!isset($post_data)) {
                $error[] = 'The post data is not set';
                return $this->renderAjax('_result', [
                    'error' => $error,
                ]);
            }

            $rss = Sourse::findOne($post_data['rss']);

            if ($rss === null) {
                $error[] = 'The rss is not found';
                return $this->renderAjax('_result', [
                    'error' => $error,
                ]);
            }
            

            return $this->renderAjax('rss/_single_details', [
                    'rss' => $rss,
                    //'keywords_stats' => $subject->phraseStats(),
            ]);
            

        }
        else{
            Yii::$app->session->setFlash('error', 'Fuck, hands off of this page.');
            return $this->redirect(['site/index']);
        }
    }

    public function actionLoadDetailsMail()
    {
        if(Yii::$app->request->isAjax){

            $error = [];
            $info = [];

            $post_data = Yii::$app->request->post();

            if (!isset($post_data)) {
                $error[] = 'The post data is not set';
                return $this->renderAjax('_result', [
                    'error' => $error,
                ]);
            }

            $mail = Sourse::findOne($post_data['mail']);

            if ($mail === null) {
                $error[] = 'The mail is not found';
                return $this->renderAjax('_result', [
                    'error' => $error,
                ]);
            }
            

            return $this->renderAjax('mail/_single_details', [
                    'mail' => $mail,
                    //'keywords_stats' => $subject->phraseStats(),
            ]);
            

        }
        else{
            Yii::$app->session->setFlash('error', 'Fuck, hands off of this page.');
            return $this->redirect(['site/index']);
        }
    }
    
    public function actionCreateNews()
    {
        if(Yii::$app->request->isAjax){

            $error = [];
            $info = [];

            $post_data = Yii::$app->request->post();

            if (!isset($post_data)) {
                $error[] = 'The post data is not set';
                return $this->renderAjax('_result', [
                    'error' => $error,
                ]);
            }

            if (empty($post_data['title'])) {
                $error[] = 'The title is null';
                return $this->renderAjax('_result', [
                    'error' => $error,
                ]);
            }
            
            if (empty($post_data['preview'])) {
                $error[] = 'The preview is null';
                return $this->renderAjax('_result', [
                    'error' => $error,
                ]);
            }

            if (empty($post_data['text'])) {
                $error[] = 'The text is null';
                return $this->renderAjax('_result', [
                    'error' => $error,
                ]);
            }

            $new_post = new Post();
            $new_post->title = trim($post_data['title']);
            $new_post->preview = trim($post_data['preview']);
            $new_post->content = trim($post_data['text']);
            $new_post->status = Post::STATUS_SAVE;
            if ($new_post->save()) {
                $info[] = 'Пост сохранен ('.Html::a('посмотреть',['post/view','id' => $new_post->id],['target' => '_black']).').';
                return $this->renderAjax('_result', [
                    'info' => $info,
                ]);
            }else{
                foreach ($new_post->getErrors() as $er) {
                    $error[] = $er[0];
                }
                return $this->renderAjax('_error', [
                    'error' => $error,
                ]);
            }
            
            

        }
        else{
            Yii::$app->session->setFlash('error', 'Fuck, hands off of this page.');
            return $this->redirect(['site/index']);
        }
    }
    
}
