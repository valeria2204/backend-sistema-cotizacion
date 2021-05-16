<?php

use Illuminate\Database\Seeder;
use App\RequestQuotitation;

class RequestQuotitationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $reqQuotation = new RequestQuotitation();
        $reqQuotation->nameUnidadGasto ="Sistemas" ;
        $reqQuotation->aplicantName = "tom";
        $reqQuotation->requestDate = "2021-02-03";
        $reqQuotation->amount = "3000";
        $reqQuotation->spending_units_id = 1;
        $reqQuotation->administrative_unit_id = 1;
        $reqQuotation->save();

        $reqQuotation = new RequestQuotitation();
        $reqQuotation->nameUnidadGasto ="Sistemas" ;
        $reqQuotation->aplicantName = "tom";
        $reqQuotation->requestDate = "2021-04-10";
        $reqQuotation->amount = "7000";
        $reqQuotation->spending_units_id = 1;
        $reqQuotation->administrative_unit_id = 1;
        $reqQuotation->save();

        $reqQuotation = new RequestQuotitation();
        $reqQuotation->nameUnidadGasto ="Sistemas" ;
        $reqQuotation->aplicantName = "tom";
        $reqQuotation->requestDate = "2021-04-10";
        $reqQuotation->amount = "7000";
        $reqQuotation->spending_units_id = 1;
        $reqQuotation->administrative_unit_id = 1;
        $reqQuotation->save();

        $reqQuotation = new RequestQuotitation();
        $reqQuotation->nameUnidadGasto ="Sistemas" ;
        $reqQuotation->aplicantName = "tom";
        $reqQuotation->requestDate = "2021-04-10";
        $reqQuotation->amount = "7000";
        $reqQuotation->spending_units_id = 1;
        $reqQuotation->administrative_unit_id = 1;
        $reqQuotation->save();

        $reqQuotation = new RequestQuotitation();
        $reqQuotation->nameUnidadGasto ="Informática" ;
        $reqQuotation->aplicantName = "Marco";
        $reqQuotation->requestDate = "2021-05-05";
        $reqQuotation->amount = "8000";
        $reqQuotation->spending_units_id = 2;
        $reqQuotation->administrative_unit_id = 1;
        $reqQuotation->save();

        $reqQuotation = new RequestQuotitation();
        $reqQuotation->nameUnidadGasto ="Informática" ;
        $reqQuotation->aplicantName = "Marco";
        $reqQuotation->requestDate = "2021-05-05";
        $reqQuotation->amount = "4000";
        $reqQuotation->spending_units_id = 2;
        $reqQuotation->administrative_unit_id = 1;
        $reqQuotation->save();

        $reqQuotation = new RequestQuotitation();
        $reqQuotation->nameUnidadGasto ="Informática" ;
        $reqQuotation->aplicantName = "Marco";
        $reqQuotation->requestDate = "2021-05-07";
        $reqQuotation->amount = "8000";
        $reqQuotation->spending_units_id = 2;
        $reqQuotation->administrative_unit_id = 1;
        $reqQuotation->save();
    }
}
