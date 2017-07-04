<?php

namespace frontend\controllers;

use EasyWeChat\Foundation\Application;
use EasyWeChat\Message\News;
use EasyWeChat\Url\Url;
use yii\web\Controller;

class WeChatController extends Controller
{
    public $enableCsrfValidation = false;

    public function actionIndex(){
        $app= new Application(\Yii::$app->params['wechat']);
        $server=$app->server;
        $server->setMessageHandler(function ($message) {
            switch ($message->Msgtype){
                case 'text':
                    switch ($message->Content){
                            case '成都':
                               $msg=simplexml_load_file('http://flash.weather.com.cn/wmaps/xml/sichuan.xml');
                            foreach ($msg as $city){
                                if($city['cityname']=='成都'){
                                    $weather = $city['stateDetailed'];
                                    break;
                                }
                            };
                            return '收到的你消息：'.$weather;
                            break;

                            case '注册';
                                $url = \yii\helpers\Url::to(['user/register'],true);
                            return '点此注册'.$url;
                            break;


                           case '活动':
                               $news1 = new News([
                                   'title'       => '五一大促',
                                   'description' => '买一送一',
                                   'url'         => 'http://www.baidu.com',
                                   'image'       => 'http://pic27.nipic.com/20130131/1773545_150401640000_2.jpg',
                                   // ...
                               ]);
                               $news2 = new News([
                                   'title'       => '六一大促',
                                   'description' => '买一送一',
                                   'url'         => 'http://www.qq.com',
                                   'image'       => 'http://pic2.16pic.com/00/16/14/16pic_1614940_b.jpg',
                                   // ...
                               ]);
                               $news3 = new News([
                                   'title'       => '七一大促',
                                   'description' => '买一送一',
                                   'url'         => 'http://www.sina.com',
                                   'image'       => 'http://pic11.nipic.com/20101203/5845502_140150276068_2.jpg',
                                   // ...
                               ]);
                               $news4 = new News([
                                   'title'       => '八一大促',
                                   'description' => '买一送一',
                                   'url'         => 'http://www.163.com',
                                   'image'       => 'http://pic2.ooopic.com/11/08/43/56b1OOOPICdf.jpg',
                                   // ...
                               ]);
                               return [$news1,$news2,$news3,$news4];
                               break;
                    }
                    return '收到你消息：'.$message->Content;
                    break;
            }
        });
        $server->serve()->send();

    }

}
