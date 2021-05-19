<?php

use Illuminate\Database\Seeder;
use App\SpendingUnit;

class SpendingUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $SpendingUnit=new SpendingUnit();
        $SpendingUnit->nameUnidadGasto="laboratorios de informatica";
        $SpendingUnit->faculties_id=1;
        $SpendingUnit->save();

        $SpendingUnit2=new SpendingUnit();
        $SpendingUnit2->nameUnidadGasto="biblioteca de economia";
        $SpendingUnit2->faculties_id=3;
        $SpendingUnit2->save();

        $SpendingUnit3=new SpendingUnit();
        $SpendingUnit3->nameUnidadGasto="biblioteca de tecnologia";
        $SpendingUnit3->faculties_id=1;
        $SpendingUnit3->save();
    }
}
