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
 * @property string $color
 * @property integer $type
 * @property string $licheng
 * @property string $chejian_date
 * @property string $chejian_cycle
 * @property string $chexian_date
 * @property string $chexian_cycle
 * @property string $reg_year
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
            [['uid', 'plate_number', 'brand', 'color', 'type', 'licheng', 'chejian_date', 'chejian_cycle', 'chexian_date', 'chexian_cycle', 'reg_year', 'ctime'], 'required'],
            [['uid', 'type'], 'integer'],
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
            'color' => '颜色',
            'type' => '燃料形式',
            'licheng' => '里程数',
            'chejian_date' => '验车时间',
            'chejian_cycle' => '验车周期',
            'chexian_date' => '保险时间',
            'chexian_cycle' => '保险周期',
            'reg_year' => '首次上牌时间',
            'ctime' => '创建时间'
        ];
    }
}
