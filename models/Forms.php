<?php

namespace kouosl\forms\models;

use Yii;

/**
 * This is the model class for table "forms".
 *
 * @property int $form_id
 * @property string $body
 * @property string $title
 * @property string $author
 * @property string $date_start
 * @property string $date_end
 * @property int $maximum
 * @property string $meta_title
 * @property string $url
 * @property string $response
 */
class Forms extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'forms';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['body', 'response'], 'string'],
            [['date_start', 'date_end'], 'safe'],
            [['maximum'], 'integer'],
            [['title', 'author', 'meta_title', 'url'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'form_id' => 'Form ID',
            'body' => 'Body',
            'title' => 'Title',
            'author' => 'Author',
            'date_start' => 'Date Start',
            'date_end' => 'Date End',
            'maximum' => 'Maximum',
            'meta_title' => 'Meta Title',
            'url' => 'Url',
            'response' => 'Response',
        ];
    }
    
}
