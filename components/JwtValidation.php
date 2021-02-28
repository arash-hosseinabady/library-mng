<?php

namespace app\components;

use sizeg\jwt\JwtValidationData;

class JwtValidation extends JwtValidationData
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->validationData->setIssuer('http://library-mng.com');
        $this->validationData->setAudience('http://library-mng.org');
        $this->validationData->setId('1q2w3e4r5t');

        parent::init();
    }
}