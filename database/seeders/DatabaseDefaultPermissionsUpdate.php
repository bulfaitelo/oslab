<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseDefaultPermissionsUpdate extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(DefaultsConfigRoles::class);
        $this->call(DefaultsConfigPermissionsGroup::class);
        $this->call(DefaultsConfigPermissionsUsers::class);
        $this->call(DefaultsConfigPermissionsFinanceiro::class);
        $this->call(DefaultsConfigSetores::class);
        $this->call(DefaultsConfigPermissionsOs::class);
    }
}
