<?php

declare(strict_types=1);

use Tipoff\Authorization\Permissions\BasePermissionsMigration;

class AddFeePermissions extends BasePermissionsMigration
{
    public function up()
    {
        $permissions = [
             'view fees',
             'create fees',
             'update fees',
             'delete fees'
        ];

        $this->createPermissions($permissions);
    }
}
