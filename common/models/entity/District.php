<?php

namespace common\models\entity;

use Yii;

/**
 * This is the model class for table "district".
 *
 * @property string $id
 * @property string $province_id
 * @property string $name
 * @property integer $area_type_id
 *
 * @property Distribution[] $distributions
 * @property Province $province
 * @property AreaType $areaType
 * @property Subdistrict[] $subdistricts
 */
class District extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            \yii\behaviors\TimestampBehavior::className(),
            \yii\behaviors\BlameableBehavior::className(),
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'district';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'province_id', 'name', 'area_type_id'], 'required'],
            [['name'], 'string'],
            [['area_type_id'], 'integer'],
            [['id'], 'string', 'max' => 4],
            [['province_id'], 'string', 'max' => 2],
            [['province_id'], 'exist', 'skipOnError' => true, 'targetClass' => Province::className(), 'targetAttribute' => ['province_id' => 'id']],
            [['area_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => AreaType::className(), 'targetAttribute' => ['area_type_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'           => 'ID',
            'province_id'  => 'Province',
            'name'         => 'Name',
            'area_type_id' => 'Area Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDistributions()
    {
        return $this->hasMany(Distribution::className(), ['district_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProvince()
    {
        return $this->hasOne(Province::className(), ['id' => 'province_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAreaType()
    {
        return $this->hasOne(AreaType::className(), ['id' => 'area_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubdistricts()
    {
        return $this->hasMany(Subdistrict::className(), ['district_id' => 'id']);
    }
}
