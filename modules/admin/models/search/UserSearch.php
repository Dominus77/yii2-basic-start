<?php

namespace modules\admin\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use modules\admin\models\User;
use modules\admin\Module;

/**
 * Class UserSearch
 * @package modules\admin\models\search
 *
 * @property int $id ID
 * @property string $username Username
 * @property string $email Email
 * @property int|string $status Status
 * @property int $last_visit Last Visit
 * @property int $created_at Created
 * @property int $updated_at Updated
 * @property string $first_name First Name
 * @property string $last_name Last Name
 * @property int $registration_type Type Registration
 */
class UserSearch extends Model
{
    public $id;
    public $username;
    public $email;
    public $status;
    public $last_visit;
    public $created_at;
    public $updated_at;
    public $registration_type;
    public $first_name;
    public $last_name;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'last_visit', 'created_at', 'updated_at', 'registration_type'], 'integer'],
            [['username', 'email', 'first_name', 'last_name'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => Module::t('users', 'Created'),
            'updated_at' => Module::t('users', 'Updated'),
            'last_visit' => Module::t('users', 'Last Visit'),
            'username' => Module::t('users', 'Username'),
            'email' => Module::t('users', 'Email'),
            'status' => Module::t('users', 'Status'),
            'first_name' => Module::t('users', 'First Name'),
            'last_name' => Module::t('users', 'Last Name'),
            'registration_type' => Module::t('users', 'Registration Type'),
        ];
    }

    /**
     * @return array
     */
    public function getStatusesArray()
    {
        return User::getStatusesArray();
    }

    /**
     * Creates data provider instance with search query applied
     * @param $params
     * @return ActiveDataProvider
     * @throws \yii\base\InvalidConfigException
     */
    public function search($params)
    {
        $query = User::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'last_visit' => $this->last_visit,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'registration_type' => $this->registration_type,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'last_name', $this->last_name]);

        return $dataProvider;
    }
}
