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
        
        return $ad_list;
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

    //汽车品牌
    public function actionBrand()
    {
        $res = Brand::getBrandList();

        return ['err' => '0', 'data' => $res];
    }

    //从接口中拉取车系子类目
    public function actionCarlist()
    {
        $brand = Brand::getBrandList();

        for($i = 0; $i < count($brand); $i++)
        {
            $parentid = $brand[$i]['id'];

            $url = "http://jisucxdq.market.alicloudapi.com/car/carlist?parentid=" . $parentid;
            $appcode = "0ad37976947a4a6b89cbfe647b990789";
            $headers = array();
            array_push($headers, "Authorization:APPCODE " . $appcode);

            $res = $this->curl_execute($url, 'GET', $headers);

            if($res)
            {
                $res = json_decode($res, true);
            }

            if(!isset($res['status']) || $res['status'] != 0)
            {
                continue;
            }

            $model = new BrandChild();

            foreach($res['result'] as $result)
            {
                
                $attributes = array(
                    'name' => $result['name'],
                    'fullname' => $result['fullname'],
                    'initial' => $result['initial'],
                    'parentid' => $result['parentid'],
                    'depth' => $result['depth'],
                    'list' => json_encode($result['carlist']),
                );
                $model->isNewRecord = true;
                $model->setAttributes($attributes);
                $model->save() && $model->id=0;
            }
        }
        echo 'done';
    }


    //从接口中拉取汽车品牌数据
    //https://market.aliyun.com/products/57002002/cmapi011811.html?spm=5176.2020520132.101.5.oaW6Db#sku=yuncode581100000
    public function actionGetBrand()
    {
        $url = "http://jisucxdq.market.alicloudapi.com/car/brand";
        $appcode = "0ad37976947a4a6b89cbfe647b990789";
        $headers = array();
        array_push($headers, "Authorization:APPCODE " . $appcode);

        $res = $this->curl_execute($url, 'GET', $headers);

        if($res)
        {
            $res = json_decode($res, true);
        }



        $model = new \common\models\brand();

        for($i = 0; $i < count($res['result']); $i++)
        {
            $attributes = array(
                'name' => $res['result'][$i]['name'],
                'initial' => $res['result'][$i]['initial'],
                'parentid' => $res['result'][$i]['parentid'],
                'logo' => $res['result'][$i]['id'] . '.png',
                'depth' => $res['result'][$i]['depth'],
                'ctime' => date('Y-m-d H:i:s'),
            );
            $model->isNewRecord = true;
            $model->setAttributes($attributes);
            $model->save() && $model->id=0;
        }
        
    }

    private function curl_execute($url, $method, $headers = array())
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_FAILONERROR, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        if (1 == strpos("$".$url, "https://"))
        {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        }
        $res = curl_exec($curl);
        // curl_close($curl);
        return $res;
    }

}
