<?php

namespace api\controllers;

use common\models\Car;

class CarController extends BaseController
{
    public function actionIndex()
    {
        $uid = Yii::$app->user->identity->id;

        return ['uid' => $uid];
    }

    // http://yii-api.lg/car/abbreviation
    //获取车牌简称
    public function actionAbbreviation()
    {
        return [
            'error' => 0,
            'data' => [
                '京','津','沪','渝','蒙','新','藏','宁','桂','港','澳','黑','吉','辽','晋','冀','青','鲁','豫','苏','皖','浙','闽','赣','湘','鄂','粤','琼','甘','陕','黔','滇','川'
            ]
        ];
    }

    //获取汽车品牌
    // http://yii-api.lg/car/brand
    public function actionBrand()
    {
        return [
            ['name' => '大众', ]
        ];
    }


    public function actionAdd()
    {
        $model = new Car();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                // form inputs are valid, do something here
                return;
            }
        }

        return $this->render('add', [
            'model' => $model,
        ]);

    }

}
