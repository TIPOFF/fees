<?php

declare(strict_types=1);

use Tipoff\Authorization\Permissions\BasePermissionsMigration;

class AddFeePermissions extends BasePermissionsMigration
{
    public function up()
    {
        $permissions = [
             'view fees' => ['Owner', 'Staff'],
             'create fees' => ['Owner'],
             'update fees' => ['Owner'],
             'delete fees' => [],   // Admin only
        ];

        $this->createPermissions($permissions);
    }
}
