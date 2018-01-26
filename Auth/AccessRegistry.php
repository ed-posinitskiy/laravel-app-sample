<?php

namespace App\Auth;

/**
 * Class AccessRegistry
 *
 * @package App\Auth
 */
class AccessRegistry
{
    const R_ADMIN   = 'role.admin';
    const R_MANAGER = 'role.manager';

    const P_FULL_LOOKUP            = 'permission.full.lookup';
    const P_MANAGE_USERS           = 'permission.manage.users';
    const P_MANAGE_SYSTEM_SETTINGS = 'permission.manage.system.settings';
}
