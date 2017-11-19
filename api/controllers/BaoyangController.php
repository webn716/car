<?php

namespace api\controllers;

use Yii;


class BaoyangController extends BaseController
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionList()
    {
        $uid = yii::$app->user->id;

        
    
    }

}


