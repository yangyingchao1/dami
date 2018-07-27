<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cp_huifu_bank".
 *
 * @property int $id
 * @property string $bankName
 * @property string $bankCode
 * @property int $isDelete
 */
class HuifuBank extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cp_huifu_bank';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['bankName', 'bankCode'], 'required'],
            [['isDelete'], 'integer'],
            [['bankName'], 'string', 'max' => 50],
            [['bankCode'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'bankName' => 'Bank Name',
            'bankCode' => 'Bank Code',
            'isDelete' => 'Is Delete',
        ];
    }
}
