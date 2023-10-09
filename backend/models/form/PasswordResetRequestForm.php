<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2017-03-15 21:16
 */

namespace backend\models\form;

use Yii;
use yii\base\Model;
use yii\base\Event;
use yii\db\BaseActiveRecord;
use common\models\AdminUser;

/**
 * Password reset request form
 */
class PasswordResetRequestForm extends Model
{
    public $email;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            [
                'email',
                'exist',
                'targetClass' => AdminUser::className(),
                'filter' => ['status' => AdminUser::STATUS_ACTIVE],
                'message' => yii::t('app', 'There is no user with such email.')
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'email' => yii::t('app', 'Email'),
        ];
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return boolean whether the email was send
     */
    public function sendEmail()
    {
        /* @var $user AdminUser */
        $user = AdminUser::findOne([
            'status' => AdminUser::STATUS_ACTIVE,
            'email' => $this->email,
        ]);

        if (! $user) {
            return false;
        }

        if (! AdminUser::isPasswordResetTokenValid($user->password_reset_token)) {
            $user->generatePasswordResetToken();
        }

        Event::off(BaseActiveRecord::className(), BaseActiveRecord::EVENT_AFTER_UPDATE);

        if (! $user->save()) {
            return false;
        }

        return Yii::$app->mailer->compose([
            'html' => 'backend/passwordResetToken-html',
            'text' => 'backend/passwordResetToken-text'
        ], ['user' => $user])
            ->setFrom(Yii::$app->mailer->messageConfig['from'])
            ->setTo($this->email)
            ->setSubject('Password reset for ' . Yii::$app->name)
            ->send();
    }
}
