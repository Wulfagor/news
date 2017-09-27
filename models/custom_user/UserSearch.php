<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace app\models\custom_user;

use dektrium\user\Finder;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * UserSearch represents the model behind the search form about User.
 */
class UserSearch extends Model
{
    /** @var string */
    public $username;

    /** @var string */
    public $email;

    /** @var int */
    public $created_at;

    /** @var int */
    public $created_at_from;

    /** @var int */
    public $created_at_to;

    /** @var int */
    public $last_login_at;

    /** @var int */
    public $last_login_at_from;

    /** @var int */
    public $last_login_at_to;

    /** @var string */
    public $registration_ip;

    /** @var Finder */
    protected $finder;

    /**
     * @param Finder $finder
     * @param array $config
     */
    public function __construct(Finder $finder, $config = [])
    {
        $this->finder = $finder;
        parent::__construct($config);
    }

    /** @inheritdoc */
    public function rules()
    {
        return [
            'fieldsSafe' => [
                [
                    'username',
                    'email',
                    'registration_ip',
                    'created_at',
                    'created_at_from',
                    'created_at_to',
                    'last_login_at',
                    'last_login_at_from',
                    'last_login_at_to'
                ],
                'safe'
            ],
            'createdDefault' => [['created_at'], 'default', 'value' => null],
            'lastloginDefault' => [['last_login_at'], 'default', 'value' => null]
        ];
    }

    /** @inheritdoc */
    public function attributeLabels()
    {
        return [
            'username' => Yii::t('user', 'Username'),
            'email' => Yii::t('user', 'Email'),
            'created_at' => Yii::t('user', 'Registration time'),
            'created_at_from' => Yii::t('user', 'Registration time from'),
            'created_at_to' => Yii::t('user', 'Registration time to'),
            'last_login_at' => Yii::t('user', 'Last login'),
            'last_login_at_from' => Yii::t('user', 'Last login from'),
            'last_login_at_to' => Yii::t('user', 'Last login to'),
            'registration_ip' => Yii::t('user', 'Registration ip'),
        ];
    }

    /**
     * @param $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = $this->finder->getUserQuery();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        if ($this->created_at_from != NULL) {
            $created_at_from = strtotime($this->created_at_from);

            if ($this->created_at_to != NULL)
                $created_at_to = strtotime($this->created_at_to) + (3600 * 24);
            else
                $created_at_to = $created_at_from + (3600 * 24);

            $query->andFilterWhere(['between', 'created_at', $created_at_from, $created_at_to]);
        }

        if ($this->last_login_at_from != NULL) {

            $last_login_at_from = strtotime($this->last_login_at_from);

            if ($this->last_login_at_to != NULL)
                $last_login_at_to = strtotime($this->last_login_at_to) + (3600 * 24);
            else
                $last_login_at_to = $last_login_at_from + (3600 * 24);

            $query->andFilterWhere(['between', 'last_login_at', $last_login_at_from, $last_login_at_to]);
        }

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['registration_ip' => $this->registration_ip]);

        return $dataProvider;
    }
}
