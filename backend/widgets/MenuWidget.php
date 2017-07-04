<?php
namespace backend\widgets;

use backend\models\Menu;
use yii\bootstrap\Widget;
use yii\bootstrap\NavBar;
use yii\bootstrap\Nav;
use Yii;
class MenuWidget extends Widget{
    public function init(){
        parent::init();
    }



    public function run(){
        NavBar::begin([
            'brandLabel' => '小买卖后台管理系统',
            'brandUrl' => Yii::$app->homeUrl,
//            'options' => [
//                'class' => 'navbar-inverse navbar-fixed-top',
//            ],
        ]);
        $menuItems = [
            ['label' => '首页', 'url' => ['goods/index']],
        ];
        if (Yii::$app->user->isGuest) {
            $menuItems[] = ['label' => '登录', 'url' => ['user/login']];
        }else{
            $menuItems[] = ['label' => '注销(' . Yii::$app->user->identity->username . ')', 'url' => ['user/login-out']];

            $menus = Menu::findAll(['parent_id' => 0]);
            foreach ($menus as $menu) {
                $item = ['label' => $menu->name,'items' => []];
                foreach ($menu->children as $child) {
                    if (Yii::$app->user->can($child->url)) {
                        $item['items'][] = ['label' => $child->name, 'url' =>[$child->url]];
                    }
                }
                if (!empty($item['items'])) {
                    $menuItems[]=$item;
                }
            }
        }

        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => $menuItems,
        ]);
        NavBar::end();
    }
}
