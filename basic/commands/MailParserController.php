<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii;
use yii\console\Controller;
use yii\helpers\HtmlPurifier;

use app\commands\tools\CurlClient;

use app\models\Sourse;
use app\models\News;
use app\models\NewsFullText;

use PhpImap\Mailbox;
use PhpImap\IncomingMail;
use PhpImap\IncomingMailAttachment;






/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class MailParserController extends BaseCommand
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     */
    public function actionIndex()
    {

        for ($i=0; $i < 100000000; $i++) { 
            $this->success("Iteration: ".$i);
            $sourses = Sourse::find()->where(
                    [
                        'and',
                            ['type' => Sourse::TYPE_MAIL],
                            ['status' => Sourse::STATUS_ACTIVE]            
                    ]
                )->all();
            if (empty($sourses)) {
                $this->error('Sourses not found');
                return;
            }
            $this->parse($sourses);            
            $this->success("Sleep: 30 мин.");    
            sleep(1800);
        }
        
    }

    public function parse($sourses)
    {
        if (empty($sourses)) {
            $this->error('Sourses not found');
            return;
        }
        foreach ($sourses as $sourse) {
            $this->success("parse url: ".$sourse->url);
            $this->parseMail($sourse);
            
        }
    }

    public function parseMail($sourse)
    {
        $mailbox = new Mailbox('{imap.mail.ru:993/imap/ssl}INBOX', 'romochka.kh@bk.ru', 'gfhjkm21', __DIR__.'/files/mail/');
        // Read all messaged into an array:
        $mailsIds = $mailbox->searchMailbox('UNSEEN');
        if (empty($mailsIds) !== false) {
           $this->error('There are not unread mails'); 
           return;
        }
        foreach ($mailsIds as $id) {
            $mail = $mailbox->getMail($id);
            if (empty($mail->subject) === false) {
                if (News::findOne(['title' => trim($mail->subject)]) === null) {
                    $news = new News();
                    $news->resourse_id = $sourse->id;
                    $news->status = News::STATUS_CRAWLER;
                    $news->title = trim($mail->subject);
                    $news->time = strtotime($mail->date);
                    if ($news->save()) {
                        $new_text = new NewsFullText();
                        if (empty($mail->textPlain) === false) {
                            $new_text->text = HtmlPurifier::process($mail->textPlain);
                        }else{
                            $new_text->text = HtmlPurifier::process($mail->textHtml);
                        }
                        
                        $new_text->news_id = $news->id;
                        $new_text->save();
                    }
                    else{
                        $this->error('News is not saved for sourse id: '.$sourse->id);    
                    }
                }else{
                    $this->success('News is already saved for sourse id: '.$sourse->id);
                }
            }else{
                $this->error('The subject or content is null'); 
            }
            
        }
        
    }
}