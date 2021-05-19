<?php

namespace console\controllers;

use common\rbac\OwnerRule;
use Yii;
use yii\console\Controller;
/**
 * Инициализатор RBAC выполняется в консоли php yii my-rbac/init
 * (https://anart.ru/yii2/2016/04/11/yii2-rbac-ponyatno-o-slozhnom.html)
 */
class MyRbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        $auth->removeAll(); //На всякий случай удаляем старые данные из БД...

        // Создадим роли админа и редактора новостей
        $admin = $auth->createRole('admin');
        $user = $auth->createRole('user');

        // запишем их в БД
        $auth->add($admin);
        $auth->add($user);



        // Создаем наше правило, которое позволит проверить автора новости
        $ownerRule = new OwnerRule;

        // Запишем его в БД
        $auth->add($ownerRule);



        // Создаем разрешения. Например, просмотр админки viewAdminPage и редактирование новости updateNews
        $viewAdminPage = $auth->createPermission('viewAdminPage');
        $viewAdminPage->description = 'Просмотр админки';

        $viewOwnProfile = $auth->createPermission('viewOwnProfile');
        $viewOwnProfile->description = 'Просмотр собственной учетной записи';


        // Указываем правило OwnerRule для разрешения viewOwnProfile.
        $viewOwnProfile->ruleName = $ownerRule->name;


        $editOwnProfile = $auth->createPermission('editOwnProfile');
        $editOwnProfile->description = 'Редактирование собственной учетной записи';


        // Указываем правило OwnerRule для разрешения editOwnProfile.
        $editOwnProfile->ruleName = $ownerRule->name;



        $viewAllProfiles = $auth->createPermission('viewAllProfiles');
        $viewAllProfiles->description = 'Просмотр любой учетной записи';

        $editAllProfiles = $auth->createPermission('editAllProfiles');
        $editAllProfiles->description = 'Редактирование любой учетной записи';

        // Запишем эти разрешения в БД
        $auth->add($viewAdminPage);
        $auth->add($viewOwnProfile);
        $auth->add($editOwnProfile);
        $auth->add($viewAllProfiles);
        $auth->add($editAllProfiles);

        // Теперь добавим наследования. Для роли editor мы добавим разрешение updateNews,
        // а для админа добавим наследование от роли editor и еще добавим собственное разрешение viewAdminPage

        // Роли «Редактор новостей» присваиваем разрешение «Редактирование новости»
        $auth->addChild($user, $viewOwnProfile);
        $auth->addChild($user, $editOwnProfile);

        // админ наследует роль редактора новостей. Он же админ, должен уметь всё! :D
        $auth->addChild($admin, $user);

        // Еще админ имеет собственное разрешение - «Просмотр админки»
        $auth->addChild($admin, $viewAdminPage);
        $auth->addChild($admin, $viewAllProfiles);
        $auth->addChild($admin, $editAllProfiles);

        // Назначаем роль admin пользователю с ID 1
        $auth->assign($admin, 69);

        // Назначаем роль editor пользователю с ID 2
        $auth->assign($user, 78);
        $auth->assign($user, 86);
    }
}