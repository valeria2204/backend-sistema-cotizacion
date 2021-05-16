<?php

use Illuminate\Database\Seeder;
use App\AdministrativeUnit;
class AdministrativeUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $administrativa = new AdministrativeUnit();
        $administrativa->name = "fcyt Administrativa";
        $administrativa->faculties_id = 1;
        $administrativa->save();

        $administrativa1 = new AdministrativeUnit();
        $administrativa1->name = "fcye Administrativa";
        $administrativa1->faculties_id = 3;
        $administrativa1->save();

        $administrativa2 = new AdministrativeUnit();
        $administrativa2->name = "Umanidades Administrativa";
        $administrativa2->faculties_id = 4;
        $administrativa2->save();
    }
}
