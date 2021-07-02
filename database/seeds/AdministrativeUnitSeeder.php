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
        $AdministrativeUnit = new AdministrativeUnit();
        $AdministrativeUnit->name="Administración de Tecnología";
        $AdministrativeUnit->faculties_id="1";
        $AdministrativeUnit->save();

        $AdministrativeUnit2 = new AdministrativeUnit();
        $AdministrativeUnit2->name="Administración de ciencias Jurídicas y Políticas";
        $AdministrativeUnit2->faculties_id="2";
        $AdministrativeUnit2->save();

        $AdministrativeUnit3 = new AdministrativeUnit();
        $AdministrativeUnit3->name="Administración de Economia";
        $AdministrativeUnit3->faculties_id="3";
        $AdministrativeUnit3->save();

        $AdministrativeUnit4 = new AdministrativeUnit();
        $AdministrativeUnit4->name="Administración de Humanidades";
        $AdministrativeUnit4->faculties_id="4";
        $AdministrativeUnit4->save();
    }
}
