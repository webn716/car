<?php
namespace frontend\models;

use yii\base\Model;
use common\models\User;

/*
错误码    错误描述                    Error Description
0        成功                       Success
1        未知错误                    Unknown error
2        服务暂不可用                 Service temporarily unavailable
3        未知的方法                  Unsupported openapi method
4        接口调用次数已达到设定的上限    Open api request limit reached
5        请求来自未经授权的IP地址       Unauthorized client IP address
6        无权限访问该用户数据           No permission to access user data
7        来自该refer的请求无访问权限    No permission to access data for this referer
100      请求参数无效                 Invalid parameter
101      api key无效                Invalid API key
104      无效签名                    Incorrect signature
105      请求参数过多                 Too many parameters
106      未知的签名方法               Unsupported signature method
107      timestamp参数无效           Invalid/Used timestamp parameter
109      无效的用户资料字段名          Invalid user info field
110      无效的access token          Access token invalid or no longer valid
111      access token过期            Access token expired
210      用户不可见                   User not visible
211      获取未授权的字段              Unsupported permission
212      没有权限获取用户的email       No permission to access user email
800      未知的存储操作错误             Unknown data store API error
801      无效的操作方法                Invalid operation
802      数据存储空间已超过设定的上限     Data store allowable quota was exceeded
803      指定的对象不存在              Specified object cannot be found
804      指定的对象已存在              Specified object already exists
805      数据库操作出错，请重试         A database error occurred. Please try again
900      访问的应用不存在              No such application exists
*/

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $phone;
    public $code;
    public $password;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['phone', 'integer'],
            ['phone', 'required'],
            ['phone', 'match', 'pattern'=>'/^1[0-9]{10}$/', 'message' => '{attribute}必须为1开头的11位纯数字'],
            ['phone', 'string', 'min' => 11, 'max' => 11],
            ['phone', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This phone has already been taken.'],
            
            ['code', 'required', 'requiredValue' => $this->getSmsCode(), 'message' => '手机验证码输入错误'],  

            
            

            // ['email', 'trim'],
            // ['email', 'required'],
            // ['email', 'email'],
            // ['email', 'string', 'max' => 255],
            // ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $user->phone = $this->phone;
        $user->nickname = $this->nickname;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        
        return $user->save() ? $user : null;
    }

    public function getSmsCode() 
    {
        return 6666;
    }
}
