<?php

namespace modules\user\models\query;

use modules\user\models\User;
use yii\db\ActiveQuery;
use Yii;

/**
 * Class UserQuery
 * @package modules\user\models\query
 */
class UserQuery extends ActiveQuery
{
    /**
     * @param int $timeout
     * @return $this
     */
    public function overdue($timeout)
    {
        return $this
            ->andWhere(['status' => User::STATUS_WAIT])
            ->andWhere(['<', 'created_at', time() - $timeout]);
    }
}
