<?php
namespace common\rbac;

use yii\rbac\Item;
use yii\rbac\Rule;

class OwnerRule extends Rule
{
    public $name = 'isOwner';

    /**
     * @param string|integer $user ID пользователя.
     * @param Item $item роль или разрешение с которым это правило ассоциировано
     * @param array $params параметры, переданные в ManagerInterface::checkAccess()
     * @return boolean a value indicating whether the rule permits the role or permission it is associated with.
     */
    public function execute($user, $item, $params) //в данном случае в $params['profile'] должен передаваться объект профиля
    {
        return isset($params['profile']) ? $params['profile']->uid == $user : false;
    }
}