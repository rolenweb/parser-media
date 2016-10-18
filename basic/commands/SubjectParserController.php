<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii;
use yii\console\Controller;

use app\commands\tools\CurlClient;
use app\commands\tools\SymfonyParser;
use Symfony\Component\DomCrawler\Link;
use app\commands\tools\Recognize;

use app\models\Sourse;
use app\models\Setting;
use app\models\Subject;
use app\models\News;
use app\models\Category;
use app\models\SubjectCategory;
use app\models\NewsSites;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class SubjectParserController extends BaseCommand
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     */
    public function actionIndex()
    {

        for ($i=0; $i < 100000000; $i++) { 
            $this->success("Iteration: ".$i);
            $sourse = Sourse::findOne(['name' => 'yandex']);
            if ($sourse === NULL) {
                $this->error('Sourse not found');
                return;
            }
            if (empty($sourse->keysParse) === false) {
                foreach ($sourse->keysParse as $key) {
                    $parse_url = $sourse->urlParse($key);
                    $this->success("parse url: ".$parse_url);
                    $content = $this->gom_yt($parse_url);
                }
            }else{
                $parse_url = $sourse->urlParse();
                $this->success("parse url: ".$parse_url);
                $content = $this->gom_yt($parse_url);
            }
            
            //$content = $this->gom_yt('https://news.yandex.ru/yandsearch?text=&rpt=nnews2&grhow=clutop&catnews=51&catnews=5&catnews=49&catnews=4&catnews=636&within=7&from_day=&from_month=&from_year=&to_day=&to_month=&to_year=&numdoc=30');

            $list_subjesct = $this->listSubject($content);

            $this->parseListSubject($list_subjesct,$sourse);

            $sourse = Sourse::find()->where(['and',['name' => 'yandex'],['status' => Sourse::STATUS_ACTIVE]])->limit(1)->one();
            if (empty($sourse) === false) {
                $sourse->fullTextParseYandex2();
            }
            $this->success("Sleep: 15 мин.");    
            sleep(900);
        }
    }



    public function parseListSubject($in,$sourse)
    {
        if (empty($in)) {
            $this->error('The array of subject is NULL');
            return;
        }
        
        foreach ($in as $n => $item) {
            $html = $this->gom_yt($item['link'].'&content=alldocs');
            $subject = $this->parseSingleSubject($html);
            
            if (empty($subject) === false) {
                if (isset($item['title'])) {
                    $saved_subject = $this->saveSubject($item['title'],$item['link'],$sourse);
                }
                if (isset($subject['links']) && isset($subject['description']) && isset($subject['title'])) {
                    $this->saveNews($subject,$saved_subject);
                }
                
            }
            $this->success("parse subject: ".$item['link']);
        }
    }

    
    public function listSubject($page)
    {
        $out = [];
        $result = [];
        $client = new CurlClient();
        $parser = new SymfonyParser();
        $content = $parser->in($page, $client->getContentType())->find('h2.story-item__title > a');
        
        foreach ($content as $node) {
            $link = new Link($node, 'https://news.yandex.ru', 'GET');
            $result['link'][] = $link->getUri();
        }
        foreach ($content as $node) {
            $result['title'][] = $node->textContent;
        }
        if (empty($result['link']) === false) {
            foreach ($result['link'] as $key => $link) {
               $out[$key]['link'] = $link;
               $out[$key]['title'] = (empty($result['title'][$key]) === false) ? $result['title'][$key] : null;
            }
        }
        krsort($out);
        return $out;
    }

    public function parseSingleSubject($page)
    {
        $result = [];
        $client = new CurlClient();
        $parser = (new SymfonyParser())->in($page, $client->getContentType());
        
        $content = $parser->find('h1.story__head');
        foreach ($content as $node) {
            $result['subject_title'][] = $node->textContent;
        }

        $result['links'] = $parser->findHref('div.doc__head > h2 > a');
        
        $content = $parser->find('div.doc__head > h2 > a');
        foreach ($content as $node) {
            $result['title'][] = $node->textContent;
        }

        $content = $parser->find('div.doc__content > div.doc__text');
        foreach ($content as $node) {
            $result['description'][] = $node->textContent;
        }

        $content = $parser->find('div.doc__time');
        foreach ($content as $node) {
            $result['time'][] = $node->textContent;
        }

        return $result;
    }

    public function saveSubject($title,$url,$sourse)
    {
        $subject = Subject::findOne(['title' => $title]);
        if ($subject === NULL) {

            $new_subject = new Subject();
            $new_subject->title = $title;
            $new_subject->url = $url;
            $new_subject->resourse_id = $sourse->id;
            $new_subject->status = Subject::STATUS_SPIDER;
            if ($new_subject->save()) {
                if (Yii::$app->cache->get('sourse_'.$sourse->id) !== false) {
                    $this->saveLinkCategory(Yii::$app->cache->get('sourse_'.$sourse->id),$new_subject);
                }
                return $new_subject;
            }
        }else{
            return $subject;
        }
    }

    public function saveNews($data,$subject)
    {
        if (empty($subject) !== false) {
            return;
        }
        foreach ($data['title'] as $key => $title) {
            if (isset($data['links'][$key])) {
                $old_news = News::findOne(['url' => $data['links'][$key]]);
                if ($old_news === NULL) {
                    
                    
                    $news = new News();
                    $news->title = $title;
                    $news->url = $data['links'][$key];
                    if (isset($data['description'][$key])) {
                        $news->preview = $data['description'][$key];
                    }
                    $news->subject_id = $subject->id;
                    $news->status = News::STATUS_SPIDER;
                    if (isset($data['time'][$key])) {
                        $news->time = strtotime(date("Y-m-d").' '.$data['time'][$key]);
                    }
                    $arr_url = parse_url($data['links'][$key]);
                    if (empty($arr_url['host']) === false) {
                        $host = trim($arr_url['host']);
                        $smi = NewsSites::find()->where(['like','url',$host])->limit(1)->one();
                        if ($smi !== null) {
                            $news->news_site_id = $smi->id;
                        }
                    }
                    $news->save();
                }
            }else{
                $old_news->subject_id = $subject->id;
                $old_news->save();
            }    
        }
    }

    public function saveLinkCategory($arr,$subject)
    {
        foreach ($arr as $item) {
            if (empty($item['catnews']) === false) {
                $categoris = Category::find()->where(['and',['value' => $item['catnews']],['status' => Category::STATUS_ACTIVE]])->all();
                if (empty($categoris) === false) {
                    foreach ($categoris as $cat) {
                        $new_link = new SubjectCategory();
                        $new_link->subject_id = $subject->id;
                        $new_link->category_id = $cat->id;
                        $new_link->save();
                    }
                }
            }
            if (empty($item['keyword']) === false) {
                $subject->parse_key_id = $item['keyword'];
                $subject->save();
            }
        }
    }

        
    
    function gom_yt($url){
        $antigate = Setting::findOne(['name' => 'antigate']);
        if ($antigate === NULL) {
            $this->error('The antigate key is not set');
            return;

        }

        $recognize = new Recognize();

        $html = $this->gom($url);
                              
        if (preg_match('@Location:(.*?)\n@is', $html, $loc)){
            $loc = trim($loc[1]);
            $this->success('LOCATION!!');
            $html = $this->gom($loc);
        }

        while (strpos($html, 'action="/checkcaptcha') !== false){
            $this->success('NEED CAPTCHA!');
            // get img src
            preg_match('@<img class="image form__captcha" .*?src="(.*?)"@', $html, $cap_src);
            $cap_src = $cap_src[1];

            // form key
            preg_match('@type="hidden" name="key" value="(.*?)"@', $html, $key);
            $key = $key[1];

            // retpath
            preg_match('@type="hidden" name="retpath" value="(.*?)"@', $html, $retpath);
            $retpath = str_replace('&amp;', '&', $retpath[1]);

            // rep
            $cap_img = $this->gom($cap_src);
            if (preg_match('@Location:(.*?)\n@is', $cap_img, $loc)){
                $loc = trim($loc[1]);
                $this->success('LOCATION!!');
                $cap_img = $this->gom($loc);
            }

            $cap_img = substr($cap_img, strpos($cap_img, 'GIF89'));
            file_put_contents(Yii::getAlias('@app').'/recognize/1.gif', $cap_img);
                
            $cap_txt = $recognize->recognize(Yii::getAlias('@app').'/recognize/1.gif', $antigate->value);
            if ($cap_txt === false) {
                    # code...
            }else{
                //echo "<img src='1.gif' /> <hr> \n $key <hr> \n $cap_txt <hr> \n $retpath <hr> \n";
                $this->success('key: '.$key);
                $this->success('CAPTCHA: '.$cap_txt);
                $this->success('retpath: '.$retpath);
                // send form 
                $html = $this->gom('https://news.yandex.ru/checkcaptcha?key='.urlencode($key).'&retpath='.urlencode($retpath).'&rep='.urlencode($cap_txt));    
            }
        }
        return $html;
    }

    function gom($url, $post=0, $ps = 0)
    {
        global $login, $password, $domain, $red_book_cms,$realip;
        
        $useragent_model = Setting::findOne(['name' => 'useragent']);
        if ($useragent_model === NULL) {
            $this->error('The useragent is not set');
            return;
        }
        $user_agent = $useragent_model->value;
        
        $cookies = Yii::getAlias('@app').'/cookiefile/cookies.txt';

        $proxy_model = Setting::findOne(['name' => 'proxy']);

        if ($proxy_model !== NULL) {
            $proxy_setting = $proxy_model->value;
        }else{
            $proxy_setting = '2';
        }
        
        # Начинаем, cURL:
        $red_book_cms = curl_init();
        
        # Задаем User Agent ("браузер" нашего псевдо пользователя),
        # Задаем источник перехода - реферера.
        # cURL будет ждать выполнения функций не более 10 секунд.
        curl_setopt($red_book_cms, CURLOPT_USERAGENT, $user_agent);
        curl_setopt($red_book_cms, CURLOPT_REFERER, $url);
        curl_setopt($red_book_cms, CURLOPT_TIMEOUT, 10);
        
        # Ссылка с GET-запросом для авторизации на почте mail.ru:
        curl_setopt($red_book_cms, CURLOPT_URL, $url);
        
        # Не будем проверять SSL сертификат и Host SSL сертификата
        curl_setopt($red_book_cms, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($red_book_cms, CURLOPT_SSL_VERIFYHOST, false);
        
        # Разрешаем возвращать содержимое страницы.
        # Если понадобится, тогда автоматом переходим по перенаправлениям.
        curl_setopt($red_book_cms, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($red_book_cms, CURLOPT_FOLLOWLOCATION, 1);
        
        if ($proxy_setting == '1') {
            //HERE connet to table
            //
            //curl_setopt($red_book_cms, CURLOPT_PROXY, $realip);  
        }
       
        # Работаем с куками, cookies:
        curl_setopt($red_book_cms, CURLOPT_COOKIEFILE, $cookies);
        curl_setopt($red_book_cms, CURLOPT_COOKIEJAR, $cookies);

        if ($post == 1)
        {
            curl_setopt($red_book_cms, CURLOPT_POST, true);
            curl_setopt($red_book_cms, CURLOPT_POSTFIELDS, $ps);
        }
        curl_setopt($red_book_cms, CURLOPT_HEADER, 1);
        curl_setopt($red_book_cms, CURLOPT_HTTPHEADER, array('Upgrade-Insecure-Requests: 1'));

        curl_setopt($red_book_cms, CURLINFO_HEADER_OUT, true);
        # Запускаемся:
        $html = curl_exec($red_book_cms);
        $headers = curl_getinfo($red_book_cms, CURLINFO_HEADER_OUT);


        # Закрываемся:
        curl_close($red_book_cms);
        return $headers."\n\n=========================================\n".$html;
    }


}