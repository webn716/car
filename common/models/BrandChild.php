<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "brand_child".
 *
 * @property integer $id
 * @property string $name
 * @property string $fullname
 * @property string $initial
 * @property integer $parentid
 * @property integer $depth
 * @property string $carlist
 */
class BrandChild extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'brand_child';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'initial', 'parentid', 'depth', 'list'], 'required'],
            [['parentid', 'depth'], 'integer'],
            [['list'], 'string'],
            [['name', 'fullname', 'initial'], 'string', 'max' => 255],
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
            'fullname' => 'Fullname',
            'initial' => 'Initial',
            'parentid' => 'Parentid',
            'depth' => 'Depth',
            'list' => 'Carlist',
        ];
    }

    public static function getInfo($parentid)
    {
        $res = parent::find()->where(['parentid' => $parentid])->orderby(['id' => 'asc'])->asArray()->all();

        foreach($res as $k => &$info)
        {
            $info[$k]['list'] = json_decode($info['list'], true);
        }

        return $res;
    }
}
