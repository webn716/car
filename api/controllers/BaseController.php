<?php
namespace api\controllers;

use Yii;
use yii\web\Response;
use yii\rest\ActiveController;

use common\models\LoginForm;

//保养记录，商家录入，车主确认
//时间、公里数、项目、价格

/**
 * Base controller
 */
class BaseController extends ActiveController
{
    public $modelClass = '';
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        
        
        // yii::$app->user->id = 6;
        
        $model = new LoginForm();
        $data = array(
            'LoginForm' => array(
                'phone' => '15212345678',
                'password' => '12345678',
                'rememberMe' => 1
            )
        );
        if ($model->load($data) && $model->login()) {
        }

        // return [];
        $behaviors = parent::behaviors();  
        #定义返回格式是：JSON  
        $behaviors['contentNegotiator']['formats']['text/html'] = Response::FORMAT_JSON;  
        return $behaviors;
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
}