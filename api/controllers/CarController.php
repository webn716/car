<?php

namespace api\controllers;

use Yii;
use common\models\Car;
use common\models\Brand;
use common\models\BrandChild;

class CarController extends BaseController
{
    public function actionIndex()
    {
        $uid = Yii::$app->user->id;

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
        $res = Brand::getBrandList();

        return ['err' => '0', 'data' => $res];
    }

    //获取汽车子品牌
    // http://yii-api.lg/car/brandchild
    public function actionBrandchild()
    {
        $parentid = yii::$app->request->get('id');

        if(empty($parentid))
        {
            return ['error' => 100,'msg' => '参数无效'];
        }


        $res = BrandChild::getInfo($parentid);

        return ['err' => '0', 'data' => $res];
    }

    public function actionList()
    {
        //todo
        $uid = yii::$app->user->id;
        $data = Car::getCarList($uid);
        
        return $data;
    }


    public function actionAdd()
    {
        $data = yii::$app->request->post();
        $data['ctime'] = date('Y-M-D H:i:s');
        //todo
        $uid = yii::$app->user->id;
        if(!$uid)
        {
            return ['err' => 111, 'msg' => '请先登录'];
            exit;
        }

        $model = new Car();

        
        if ($model->load($data, '')) {
            if ($model->validate() && $model->save()) {
                // form inputs are valid, do something here
                return ['err' => '0', 'msg' => '添加成功'];
            }
        }

        return ['err' => 801, 'msg' => '无效操作'];

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
