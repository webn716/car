<?php
namespace api\controllers;

use Yii;
use common\models\LoginForm;
use api\models\PasswordResetRequestForm;
use api\models\ResetPasswordForm;
use api\models\SignupForm;

/**
 * Site controller
 */
class UserController extends BaseController
{
    public $modelClass = 'api\models\SignupForm';

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return ['msg' => 'ok'];
    }

    /**
     * Logs in a user.
     * curl -d 'LoginForm[phone]=15212345678&LoginForm[password]=12345678&LoginForm[rememberMe]=1' http://yii-api.lg/user/login
     * 
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return ['err' => '801', 'msg' => '您已登录'];
        }


        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            
            return ['error' => 0, 'msg' => '登录成功'];
        } else {
            return $this->render('/site/login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
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

    /**
     * Signs user up.
     *  curl -d 'SignupForm[phone]=13272345670&SignupForm[code]=6666&SignupForm[password]=1q2w3e' http://api.car.yipiantian.cn/user/signup
     * 
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();

        if ($model->load(Yii::$app->request->post()))
        {
            if ($user = $model->signup())
            {
                if (Yii::$app->getUser()->login($user)) {
                    return ['error' => 0, 'msg' => '注册成功'];
                }
            }
        }

    }

    //curl http://yii-api.lg/user/getcode
    //短信验证码
    public function actionGetcode()
    {
        $model = new SignupForm();

        return ['error' => 0, 'code' => $model->getSmsCode()];
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
