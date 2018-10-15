<?php
namespace app\models;
use Yii;
use yii\base\Model;

class Money extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'money';
    }
    public function getMoneySum()
    {
        $sum = $this::findOne('1');
        return $sum['sum'];
    }
    public function minusMoneySum($result)
    {
        $sum = $this::findOne('1');
        $sum->sum = $result;
        $sum->update();
        return true;
    }
}
	