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
        $SpendingUnit->nameUnidadGasto="Laboratorios de informática-sistemas";
        $SpendingUnit->faculties_id=1;
        $SpendingUnit->save();

        $SpendingUnit1=new SpendingUnit();
        $SpendingUnit1->nameUnidadGasto="Laboratorios de física";
        $SpendingUnit1->faculties_id=1;
        $SpendingUnit1->save();

        $SpendingUnit2=new SpendingUnit();
        $SpendingUnit2->nameUnidadGasto="Biblioteca de tecnología";
        $SpendingUnit2->faculties_id=1;
        $SpendingUnit2->save();

        $SpendingUnit3=new SpendingUnit();
        $SpendingUnit3->nameUnidadGasto="Biblioteca de derecho";
        $SpendingUnit3->faculties_id=2;
        $SpendingUnit3->save();

        $SpendingUnit4=new SpendingUnit();
        $SpendingUnit4->nameUnidadGasto="Centro de derecho";
        $SpendingUnit4->faculties_id=2;
        $SpendingUnit4->save();

        $SpendingUnit5=new SpendingUnit();
        $SpendingUnit5->nameUnidadGasto="Biblioteca de economia";
        $SpendingUnit5->faculties_id=3;
        $SpendingUnit5->save();
        
    }
}
