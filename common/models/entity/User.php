<?php

namespace common\models\entity;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $name
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property integer $status
 * @property string $verification_token
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property Allocation[] $allocations
 * @property Allocation[] $allocations0
 * @property AllocationBudget[] $allocationBudgets
 * @property AllocationBudget[] $allocationBudgets0
 * @property Brand[] $brands
 * @property Brand[] $brands0
 * @property Category[] $categories
 * @property Category[] $categories0
 * @property CategorySub[] $categorySubs
 * @property CategorySub[] $categorySubs0
 * @property CategorySubChild[] $categorySubChildren
 * @property CategorySubChild[] $categorySubChildren0
 * @property CategorySubChildSub[] $categorySubChildSubs
 * @property CategorySubChildSub[] $categorySubChildSubs0
 * @property Distribution[] $distributions
 * @property Distribution[] $distributions0
 * @property DistributionFile[] $distributionFiles
 * @property DistributionFile[] $distributionFiles0
 * @property Group[] $groups
 * @property Group[] $groups0
 * @property Objective[] $objectives
 * @property Objective[] $objectives0
 */
class User extends \common\models\User
{
    public $password;
    public $role;

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
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'auth_key', 'password_hash', 'email'], 'required'],
            [['status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['name', 'username', 'password_hash', 'password_reset_token', 'email', 'verification_token'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['password_reset_token'], 'unique'],

            [['password'], 'safe',],
            [['password'], 'required', 'on' => 'create',],

            [['role'], 'safe',],

            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'                   => 'ID',
            'name'                 => 'Name',
            'username'             => 'Username',
            'auth_key'             => 'Auth Key',
            'password_hash'        => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email'                => 'Email',
            'status'               => 'Status',
            'verification_token'   => 'Verification Token',
            'created_at'           => 'Created At',
            'updated_at'           => 'Updated At',
            'created_by'           => 'Created By',
            'updated_by'           => 'Updated By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthAssignments()
    {
        return $this->hasMany(AuthAssignment::className(), ['user_id' => 'id']);
    }

    public static function statuses($index = null) {
        $array = [
            self::STATUS_ACTIVE   => 'Active',
            self::STATUS_INACTIVE => 'Inactive',
        ];
        if ($index == null) return $array;
        if (isset($array[$index])) return $array[$index];
        return null;
    }

    public function getRoles()
    {
        $array = [];
        $authAssignments = AuthAssignment::findAll(['user_id' => $this->id]);
        foreach ($authAssignments as $authAssignment) {
            $array[] = $authAssignment['item_name'];
        }
        $return = implode(', ', $array);
        return $return;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAllocations()
    {
        return $this->hasMany(Allocation::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAllocations0()
    {
        return $this->hasMany(Allocation::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAllocationBudgets()
    {
        return $this->hasMany(AllocationBudget::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAllocationBudgets0()
    {
        return $this->hasMany(AllocationBudget::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBrands()
    {
        return $this->hasMany(Brand::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBrands0()
    {
        return $this->hasMany(Brand::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Category::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategories0()
    {
        return $this->hasMany(Category::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategorySubs()
    {
        return $this->hasMany(CategorySub::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategorySubs0()
    {
        return $this->hasMany(CategorySub::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategorySubChildren()
    {
        return $this->hasMany(CategorySubChild::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategorySubChildren0()
    {
        return $this->hasMany(CategorySubChild::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategorySubChildSubs()
    {
        return $this->hasMany(CategorySubChildSub::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategorySubChildSubs0()
    {
        return $this->hasMany(CategorySubChildSub::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDistributions()
    {
        return $this->hasMany(Distribution::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDistributions0()
    {
        return $this->hasMany(Distribution::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDistributionFiles()
    {
        return $this->hasMany(DistributionFile::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDistributionFiles0()
    {
        return $this->hasMany(DistributionFile::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroups()
    {
        return $this->hasMany(Group::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroups0()
    {
        return $this->hasMany(Group::className(), ['updated_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getObjectives()
    {
        return $this->hasMany(Objective::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getObjectives0()
    {
        return $this->hasMany(Objective::className(), ['updated_by' => 'id']);
    }
}
