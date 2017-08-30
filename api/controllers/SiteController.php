<?php
namespace api\controllers;

use Yii;
use yii\web\Response;

use common\models\LoginForm;
use common\models\Ad;
use common\models\Brand;
use common\models\BrandChild;
use api\models\PasswordResetRequestForm;
use api\models\ResetPasswordForm;
use api\models\SignupForm;

//文档地址：http://apizza.cc/console/project/2ba11b113aa60b9a089275a49e06632f/browse

/**
 * Site controller
 */
class SiteController extends BaseController
{
    public $modelClass = 'api\models\ContactForm';

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }


    // 首页广告
    // http://yii-api.lg/site/ads
    public function actionAds()
    {
        $ad_list = Ad::getAds('top_banner', 5);
        
        return ['error' => 0, 'data' => $ad_list];
    }


    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    

}
