<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "baoyang".
 *
 * @property integer $id
 * @property integer $uid
 * @property integer $car_id
 * @property integer $type
 * @property integer $last_licheng
 * @property integer $zhouqi
 * @property string $last_date
 * @property string $content
 */
class Baoyang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'baoyang';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'uid', 'car_id', 'type', 'last_licheng', 'zhouqi', 'last_date', 'content'], 'required'],
            [['id', 'uid', 'car_id', 'type', 'last_licheng', 'zhouqi'], 'integer'],
            [['last_date'], 'safe'],
            [['content'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => 'Uid',
            'car_id' => 'Car ID',
            'type' => 'Type',
            'last_licheng' => 'Last Licheng',
            'zhouqi' => 'Zhouqi',
            'last_date' => 'Last Date',
            'content' => 'Content',
        ];
    }

    //关联表
    public function getType()
    {
        return $this->hasOne(BaoyangType::className(),['id'=>'type']);
    }

    /*
    
    score=-1 未设定，score>0 进度条百分比
    保养分两种规则：
    1.里程，5千公里，默认
    2.周期，6个月，优先判断
    */
    public static function getBaoyangList($uid)
    {
        $list = self::find()->where(['uid' => $uid])->asArray()->all();

        //将索引设置成保养类型
        $baoyang_list = [];
        if(!empty($list)) foreach($list as $item)
        {
            $type = $item['type'];
            $baoyang_list[$type] = $item;
        }

        $type_list = BaoyangType::find()->orderby(['sort' => 'asc'])->asArray()->all();

        if(!empty($type_list))
        {
            foreach($type_list as &$type)
            {
                $id = $type['id'];
                
                //进度
                if(!empty($baoyang_list) && !empty($baoyang_list[$id]))
                {
                    

                    $last_licheng = $baoyang_list[$id]['last_licheng'];
                    $zhouqi = $baoyang_list[$id]['zhouqi'];
                    $last_date = $baoyang_list[$id]['last_date'];

                    if($zhouqi && $last_date)
                    {

                    }


                }
                else
                {
                    $type['score'] = -1;
                }
            }
        }
        

        return $list;
    }
}
