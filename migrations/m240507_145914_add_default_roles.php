<?php

use yii\db\Migration;

/**
 * Class m240507_145914_add_default_roles
 */
class m240507_145914_add_default_roles extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        $user = $auth->createRole(\app\components\RBACAccess::ROLE_USER);
        $auth->add($user);
        
        $admin = $auth->createRole(\app\components\RBACAccess::ROLE_ADMIN);
        $auth->add($admin);
            
//        $auth->addChild($author, $createPost);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return true;
    }
}
