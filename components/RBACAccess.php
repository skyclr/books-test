<?php

namespace app\components;

/**
 * Class RBACAccess
 * @package app\components
 */
class RBACAccess
{
    const ROLE_ADMIN = 'admin';
    const ROLE_USER = 'user';
    
    const PERMISSION_ADD_BOOK = 'addBook';
    const PERMISSION_UPDATE_BOOK = 'updateBook';
    const PERMISSION_DELETE_BOOK = 'deleteBook';
    const PERMISSION_VIEW_BOOK = 'viewBook';
}
