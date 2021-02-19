<?php

declare(strict_types=1);

namespace Tipoff\Fees\Tests\Unit\Migrations;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Tipoff\Fees\Tests\TestCase;

class PermissionsMigrationTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function permissions_seeded()
    {
        $this->assertTrue(Schema::hasTable('permissions'));

        $seededPermissions = app(Permission::class)->whereIn('name', [
            'view fees',
            'create fees',
            'update fees',
            'delete fees',
        ])->pluck('name');

        $this->assertCount(4, $seededPermissions);
    }
}
