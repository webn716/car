<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "brand".
 *
 * @property integer $id
 * @property string $name
 * @property string $initial
 * @property integer $parentid
 * @property string $logo
 * @property string $depth
 * @property string $ctime
 */
class Brand extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'brand';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'initial', 'parentid', 'logo', 'depth', 'ctime'], 'required'],
            [['parentid'], 'integer'],
            [['ctime'], 'safe'],
            [['name', 'initial', 'logo', 'depth'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'initial' => 'Initial',
            'parentid' => 'Parentid',
            'logo' => 'Logo',
            'depth' => 'Depth',
            'ctime' => 'Ctime',
        ];
    }

    public static function getBrandList()
    {
        $res = parent::find()->select(['id', 'name', 'initial', 'logo'])->orderby(['id' => 'asc'])->asArray()->all();

        return $res;
    }
}
