<?php

namespace api\controllers;

use Yii;
use common\models\Baoyang;


class BaoyangController extends BaseController
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionList()
    {
        $uid = yii::$app->user->id;

        $res = Baoyang::getBaoyangList($uid);

        return ["data" => 'aaaaa', "uid" => $uid];
    }

}


