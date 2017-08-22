<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "ad".
 *
 * @property integer $id
 * @property integer $cid
 * @property string $tag
 * @property string $name
 * @property string $path
 * @property string $link
 */
class Ad extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ad';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cid', 'tag', 'name', 'path', 'link'], 'required'],
            [['cid'], 'integer'],
            [['tag', 'name', 'path', 'link'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cid' => '分类ID',
            'tag' => '标识',
            'name' => '广告标题',
            'path' => '文件地址',
            'link' => '链接',
        ];
    }

    public static function getAds($tag, $limit = 5, $by = 'DESC')
    {
        return parent::find()->where(['tag' => $tag])->limit($limit)->orderby(['id' => $by])->all();
    }
}
