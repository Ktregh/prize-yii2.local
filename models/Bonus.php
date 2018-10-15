<?php
namespace app\models;
use Yii;
use yii\base\Model;

class Bonus extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'bonus';
    }
    public function setBonus($user_id, $change)
    {
        $bonus = $this::find()->where(['user_id' => $user_id])->one();
        if($bonus)
        {
            $bonus->bonus = ($bonus->bonus + $change);
            $bonus->update();
            return true;
        }
        else
        {
            $bonus = new Bonus();
            $bonus->bonus = $change;
            $bonus->user_id = $user_id;
            $bonus->save();
            return true;
        }
    }
    public function getBonus($user_id)
    {
        $bonus = $this::find()->where(['user_id' => $user_id])->asArray()->one();
        return $bonus['bonus'];
    }
}
	