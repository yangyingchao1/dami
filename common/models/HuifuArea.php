<?php

namespace common\models;


use Yii;

/**
 * This is the model class for table "cp_huifu_area".
 *
 * @property int $id
 * @property string $provId
 * @property string $provName
 * @property string $cityId
 * @property string $cityName
 */
class HuifuArea extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cp_huifu_area';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['provId', 'provName', 'cityId', 'cityName'], 'required'],
            [['provId', 'cityId'], 'string', 'max' => 4],
            [['provName', 'cityName'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'provId' => 'Prov ID',
            'provName' => 'Prov Name',
            'cityId' => 'City ID',
            'cityName' => 'City Name',
        ];
    }
}
