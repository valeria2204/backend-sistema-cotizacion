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
        $spending = new SpendingUnit();
        $spending->nameUnidadGasto = "Sistemas";
        $spending->faculties_id = 1;
        $spending->save();

        $spending1 = new SpendingUnit();
        $spending1->nameUnidadGasto = "Informática";
        $spending1->faculties_id = 1;
        $spending1->save();

        $spending2 = new SpendingUnit();
        $spending2->nameUnidadGasto = "Auditoria";
        $spending2->faculties_id = 2;
        $spending2->save();

        $spending3 = new SpendingUnit();
        $spending3->nameUnidadGasto = "Cormercial";
        $spending3->faculties_id = 2;
        $spending3->save();

        $spending4 = new SpendingUnit();
        $spending4->nameUnidadGasto = "Trabajo Social";
        $spending4->faculties_id = 4;
        $spending4->save();
        
        $spending6 = new SpendingUnit();
        $spending6->nameUnidadGasto = "Musica";
        $spending6->faculties_id = 4;
        $spending6->save();
    }
}
