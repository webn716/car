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

    public static function getBaoyangList($uid)
    {
        $list = parent::find()->where(['uid' => $uid])->all();

        if(empty($list))
        {
            $type_list = BaoyangType::find()->orderby(['sort' => 'asc'])->all();
        }
    }
}
