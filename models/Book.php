<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "book".
 *
 * @property int $id
 * @property string $name
 * @property string $desc
 * @property int $writer_id
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Writer $writer
 */
class Book extends \yii\db\ActiveRecord
{
    use ModelTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'book';
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'desc', 'writer_id'], 'required'],
            [['writer_id', 'created_at', 'updated_at'], 'integer'],
            [['name', 'desc'], 'string', 'max' => 255],
            [['writer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Writer::className(), 'targetAttribute' => ['writer_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'desc' => Yii::t('app', 'Desc'),
            'writer_id' => Yii::t('app', 'Writer'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[Writer]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWriter()
    {
        return $this->hasOne(Writer::className(), ['id' => 'writer_id']);
    }
}
