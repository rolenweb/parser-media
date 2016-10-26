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

use app\commands\tools\CurlClient;

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
                'only' => ['logout','index','login','load-details-subject','processed-subject','reload-left-area','processed-news','create-news','search-speaker'],
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
                        'actions' => ['index','load-details-subject','processed-subject','reload-left-area','processed-news','create-news','search-speaker'],
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
        $query_subject = Subject::find()->joinWith(['news.smi'])->where([
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

                $news = News::find()->joinWith(['sourse'])->where([
                        'and',
                            [
                                'sourse.type' => Sourse::TYPE_RSS,
                                'sourse.status' => Sourse::STATUS_ACTIVE,
                            ],
                            [
                                'or',
                                    [
                                        'news.status' => News::STATUS_SPIDER
                                    ],
                                    [
                                        'news.status' => News::STATUS_CRAWLER  
                                    ]
                                
                            ],
                    ])->orderBy(['news.time' => SORT_DESC])->all();
                return $this->renderAjax('rss/_list_preview_news', [
                    'news' => $news,
                    
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

            if (empty($post_data['news'])) {
                $error[] = 'The news id is not set';
                return $this->renderAjax('_result', [
                    'error' => $error,
                ]);   
            }

            $news = News::findAll($post_data['news']);

            if (empty($news)) {
                $error[] = 'The news is not found';
                return $this->renderAjax('_result', [
                    'error' => $error,
                ]);
            }
            

            return $this->renderAjax('rss/_single_details', [
                    'news' => $news,
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
    
    public function actionSearchSpeaker()
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

            if (empty($post_data['name'])) {
                $error[] = 'The name is null';
                return $this->renderAjax('_result', [
                    'error' => $error,
                ]);
            }
            $client = new CurlClient();
            
            $useragent = 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US) AppleWebKit/533.2 (KHTML, like Gecko) Chrome/5.0.342.3 Safari/533.2';
            array_map('unlink', glob("cookiefile/*"));
            $ckfile = tempnam(Yii::getAlias('@app')."/cookiefile", "CURLCOOKIE");
            $f = fopen(Yii::getAlias('@app').'/cookiefile/log.txt', 'w'); 
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
            curl_setopt($ch, CURLOPT_COOKIEJAR, $ckfile);
            curl_setopt($ch, CURLOPT_COOKIEFILE, $ckfile);
            curl_setopt($ch, CURLOPT_URL, 'http://www.nutcall.com/');
            curl_setopt($ch, CURLOPT_REFERER, 'http://www.nutcall.com/');
            
            $webpage = curl_exec($ch);
            curl_close($ch);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
            curl_setopt($ch, CURLOPT_COOKIEJAR, $ckfile);
            curl_setopt($ch, CURLOPT_COOKIEFILE, $ckfile);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch,CURLOPT_VERBOSE,true);
            curl_setopt($ch,CURLOPT_STDERR ,$f);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-Requested-With: XMLHttpRequest", "Accept: application/json, text/javascript, */*; q=0.01", "Accept-Encoding: gzip, deflate", "Accept-Language: en-US,en;q=0.8","Content-Type: application/x-www-form-urlencoded; charset=UTF-8","Origin: http://www.nutcall.com"));
            curl_setopt($ch, CURLOPT_POSTFIELDS, 'action=login&email=rufrom@gmail.com&password=1233213&tmp=1');
            curl_setopt($ch, CURLOPT_URL, 'http://www.nutcall.com/users/?do=ajax');
            curl_setopt($ch, CURLOPT_REFERER, 'http://www.nutcall.com');

            $webpage = curl_exec($ch);
            
            //var_dump($webpage);
            curl_close($ch);


            $ch = curl_init();
            curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
            curl_setopt($ch, CURLOPT_COOKIEJAR, $ckfile);
            curl_setopt($ch, CURLOPT_COOKIEFILE, $ckfile);
            curl_setopt($ch, CURLOPT_URL, 'http://www.nutcall.com/');
            curl_setopt($ch, CURLOPT_REFERER, 'http://www.nutcall.com/');
            
            $webpage = curl_exec($ch);

            //var_dump($webpage);

            curl_close($ch);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
            curl_setopt($ch, CURLOPT_COOKIEJAR, $ckfile);
            curl_setopt($ch, CURLOPT_COOKIEFILE, $ckfile);
            curl_setopt($ch, CURLOPT_URL, 'http://www.nutcall.com/ru/search/?s=all&q='.urlencode($post_data['name']));
            curl_setopt($ch, CURLOPT_REFERER, 'http://www.nutcall.com/');
            
            $webpage = curl_exec($ch);
            
            curl_close($ch);

            //var_dump($webpage);
            $names = $client->parseProperty($webpage,'string','div.shortlist-block-item div.info div.name a');
            $notes = $client->parseProperty($webpage,'string','div.shortlist-block-item div.info div.note');
            //$tags = $client->parseProperty($webpage,'string','div.shortlist-block-item div.info div.tags');

            $photos = $client->parseProperty($webpage,'attribute','div.shortlist-block-item div.photo a img',null,'src');
            

            
            return $this->renderAjax('subject/modal/_result_search', [
                    'names' => $names,
                    'notes' => $notes,
                    'photos' => $photos,

            ]);
            
            

        }
        else{
            Yii::$app->session->setFlash('error', 'Fuck, hands off of this page.');
            return $this->redirect(['site/index']);
        }
    }
}
