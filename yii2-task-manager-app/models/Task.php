<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "task".
 *
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property string|null $created_at
 * @property string|null $completed_at
 * @property string $status
 */
class Task extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'task';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['description'], 'string'],
            [['created_at', 'completed_at'], 'safe'],
            [['title', 'status'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'created_at' => 'Created At',
            'completed_at' => 'Completed At',
            'status' => 'Status',
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->status === 'completed' && empty($this->completed_at)) {
                $this->completed_at = date('Y-m-d H:i:s');
            } elseif ($this->status !== 'completed') {
                $this->completed_at = null; // Clear completed_at if status is not completed
            }
            return true;
        }
        return false;
    }
}
