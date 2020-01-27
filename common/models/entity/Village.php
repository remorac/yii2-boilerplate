<?php

namespace common\models\entity;

use Yii;

/**
 * This is the model class for table "village".
 *
 * @property string $id
 * @property string $subdistrict_id
 * @property string $name
 * @property integer $area_type_id
 *
 * @property Distribution[] $distributions
 * @property Subdistrict $subdistrict
 * @property AreaType $areaType
 */
class Village extends \yii\db\ActiveRecord
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
        return 'village';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'area_type_id'], 'required'],
            [['name'], 'string'],
            [['area_type_id'], 'integer'],
            [['id'], 'string', 'max' => 10],
            [['subdistrict_id'], 'string', 'max' => 6],
            [['subdistrict_id'], 'exist', 'skipOnError' => true, 'targetClass' => Subdistrict::className(), 'targetAttribute' => ['subdistrict_id' => 'id']],
            [['area_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => AreaType::className(), 'targetAttribute' => ['area_type_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'subdistrict_id' => 'Subdistrict',
            'name' => 'Name',
            'area_type_id' => 'Area Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDistributions()
    {
        return $this->hasMany(Distribution::className(), ['village_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubdistrict()
    {
        return $this->hasOne(Subdistrict::className(), ['id' => 'subdistrict_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAreaType()
    {
        return $this->hasOne(AreaType::className(), ['id' => 'area_type_id']);
    }
}
