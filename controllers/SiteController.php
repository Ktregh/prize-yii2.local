<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\Money;
use app\models\Bonus;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
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
     * {@inheritdoc}
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
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionPrizes()
    {
        if (\Yii::$app->request->isAjax)
        {
            $session = \Yii::$app->session;
            $session->open();
            $first = 2;
            $second = 2;
            $money = new Money;
            $sum = $money->getMoneySum(); //проверка наличия денег в кассе
            if($sum > 0) //если деньги есть, тогда тип приза "деньги" участвует в розыгрыше
            {    
                $first = 1;
            }
            
            //$prize = new Prize;
            /*$quantity = $prize->checkPrizeQuantity();//проверка наличия призов
            if($quantity)
            {
                $second = 3;
            }*/
            $type = 1;
            
            //$type = rand($first, $second); // получаем тип приза 1 - деньги; 2 - балы; 3 - предмет
            if($type == 1) //приз - деньги
            {
                if($sum < 100)
                {
                    $prize = rand(1, $sum); //если денег меньше 100
                }
                else
                {
                    $prize = rand(1, 100);
                }
                $session['prize'] = $prize;
                $money->minusMoneySum($sum - $prize);
                                
            }
           /* if($type == 2) //приз - бонусы
            {
                $data['prize'] = rand(100, 200); 
                $user = new User;
                $login = $_SESSION['login'];
                //$bonussum = $user->getBonus($login);
                $data['result'] = $user->plusBonus($login, $data['prize']);
                $data['bonus'] = $user->getBonus($login);
                $data['type'] = $type;
                echo json_encode($data);
            }
            if($type == 3) //приз - предметы
            {
                $thing = $prize->getPrize();
                $_SESSION['prize'] = $thing['prize'];
                $data['prize'] = $thing['prize'];
                $data['type'] = $type;
                echo json_encode($data);
            }*/
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
                'type' => $type,
                'prize' => $prize,
            ];
        }
        return false;
    }
    public function actionChangeMoney()
    {
        if (\Yii::$app->request->isAjax)
        {
            $session = \Yii::$app->session;
            $session->open();
            $prize = $session['prize'];
            $change = $prize * 2; //коэффициент обмена денег на бонусы
            $bonus = new Bonus;
            $bonusresult = $bonus->setBonus(\Yii::$app->user->identity->id, $change);
            if($bonusresult)
            {
                $result = "Деньги успешно переведены в баллы";
                $bonus = $bonus->getBonus(\Yii::$app->user->identity->id);
            }
            else 
            {
                $result = "Что-то пошло не так111111";
            }
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
                'result' => $result,
                'bonus' => $bonus,
                'prize' => $prize,
            ];
        }
        return false;
    }
}
