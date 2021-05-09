<?php

use Illuminate\Database\Seeder;
use App\Role;
class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = new Role();
        $role->nameRol = "Jefe unidad de gasto";
        $role->description = "es el encargado de toda la parte de la unidad de gasto";
        $role->save();
        $role->permissions()->attach([1,2]);

        $role2 = new Role();
        $role2->nameRol = "Jefe Administrarivo";
        $role2->description = "es el encargado de toda la parte de la unidad de administración";
        $role2->save();
        $role2->permissions()->attach([3,4,5,6]);

        $role3 = new Role();
        $role3->nameRol = "administrador";
        $role3->description = "es el que se encarga de admistrar el sistemas";
        $role3->save();
        $role3->permissions()->attach([7,8,9]);
    }
}
