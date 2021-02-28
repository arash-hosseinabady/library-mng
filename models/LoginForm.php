<?php

namespace app\models;

use webvimark\modules\UserManagement\models\forms\LoginForm as BaseLoginForm;

/**
 * LoginForm is the model behind the login form.
 *
 * @property-read User|null $user This property is read-only.
 *
 */
class LoginForm extends BaseLoginForm
{

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return parent::rules();
    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        return parent::login();
    }
}
