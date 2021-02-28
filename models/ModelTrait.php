<?php


namespace app\models;


use yii\behaviors\TimestampBehavior;

trait ModelTrait
{
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    public function getCreatedAt()
    {
        return date('Y-m-d H:i:s', $this->created_at);
    }

    public function getUpdatedAt()
    {
        return date('Y-m-d H:i:s', $this->created_at);
    }
}