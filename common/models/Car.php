<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "car".
 *
 * @property integer $id
 * @property integer $uid
 * @property string $plate_number
 * @property string $brand
 * @property string $licheng
 * @property string $chejian_date
 * @property string $chexian_date
 * @property string $ctime
 */
class Car extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'car';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'plate_number', 'brand', 'licheng', 'chejian_date', 'chexian_date', 'ctime'], 'required'],
            [['uid'], 'integer'],
            [['chejian_date', 'chexian_date', 'ctime'], 'safe'],
            [['plate_number', 'brand', 'licheng'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => '用户ID',
            'plate_number' => '车牌号',
            'brand' => '品牌',
            'licheng' => '里程数',
            'chejian_date' => '年检时间',
            'chexian_date' => '车险时间',
            'ctime' => '创建时间',
        ];
    }
}
