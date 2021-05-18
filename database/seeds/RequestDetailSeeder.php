<?php

use Illuminate\Database\Seeder;
use App\RequestDetail;

class RequestDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $reqDetail = new RequestDetail();
        $reqDetail->amount = 2;
        $reqDetail->unitMeasure = "mesas";
        $reqDetail->description = "marca php color preferente negro";
        $reqDetail->request_quotitations_id = 1;
        $reqDetail->save();

        $reqDetail = new RequestDetail();
        $reqDetail->amount = 5;
        $reqDetail->unitMeasure = "laptops";
        $reqDetail->description = "marca php color preferente negro";
        $reqDetail->request_quotitations_id = 2;
        $reqDetail->save();

        $reqDetail = new RequestDetail();
        $reqDetail->amount = 5;
        $reqDetail->unitMeasure = "mause";
        $reqDetail->description = "marca php color preferente negro";
        $reqDetail->request_quotitations_id = 2;
        $reqDetail->save();
    }
}
