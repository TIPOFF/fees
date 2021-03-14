<?php

declare(strict_types=1);

use Tipoff\Authorization\Permissions\BasePermissionsMigration;

class AddFeePermissions extends BasePermissionsMigration
{
    public function up()
    {
        $permissions = [
             'view fees' => ['Owner', 'Executive', 'Staff'],
             'create fees' => ['Owner', 'Executive'],
             'update fees' => ['Owner', 'Executive'],
        ];

        $this->createPermissions($permissions);
    }
}
