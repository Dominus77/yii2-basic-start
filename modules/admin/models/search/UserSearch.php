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
 * @property string $role User Role Name
 * @property string $date_from Date From
 * @property string $date_to Date To
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
    public $first_name;
    public $last_name;
    public $role;
    public $date_from;
    public $date_to;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['username', 'email', 'first_name', 'last_name', 'role', 'date_from', 'date_to'], 'safe'],
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
            'role' => Module::t('users', 'Role'),
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
     * @return object|\yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    protected function getQuery()
    {
        $query = User::find();
        $query->leftJoin('{{%auth_assignment}}', '{{%auth_assignment}}.user_id = {{%user}}.id');
        return $query;
    }

    /**
     * @param \yii\db\ActiveQuery $query
     * @return ActiveDataProvider
     */
    protected function getDataProvider($query)
    {
        return new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_ASC],
                'attributes' => [
                    'id',
                    'username',
                    'email',
                    'status',
                    'role' => [
                        'asc' => ['item_name' => SORT_ASC],
                        'desc' => ['item_name' => SORT_DESC],
                        'default' => SORT_ASC,
                    ],
                    'last_visit'
                ]
            ],
        ]);
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     * @throws \yii\base\InvalidConfigException
     */
    public function search($params)
    {
        $query = $this->getQuery();
        $dataProvider = $this->getDataProvider($query);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $this->processFilter($query);

        return $dataProvider;
    }

    /**
     * @param $query \yii\db\QueryInterface
     */
    protected function processFilter($query)
    {
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'item_name' => $this->role,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['>=', 'last_visit', $this->date_from ? strtotime($this->date_from . ' 00:00:00') : null])
            ->andFilterWhere(['<=', 'last_visit', $this->date_from ? strtotime($this->date_from . ' 23:59:59') : null]);
    }
}
