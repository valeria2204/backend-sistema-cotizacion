<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = "admin";
        $user->lastName="sistema";
        $user->phone="64906868";
        $user->direction="cbba-sacaba";
        $user->ci="96523250";
        $user->email="admin@gmail.com";
        $user->userName="admin";
        $user->password=bcrypt("admin");
        $user->save();
        $user->roles()->attach(3);

        $user = new User();
        $user->name = "Jennifer";
        $user->lastName="Rojas";
        $user->phone="7412589";
        $user->direction="cbba-Quillacollo";
        $user->ci="12345671";
        $user->email="jenny@gmail.com";
        $user->userName="jenny";
        $user->password=bcrypt("jenny");
        //$user->administrative_units_id=1;
        $user->save();
        $user->roles()->attach(2,['administrative_unit_id'=>1,'administrative_unit_status'=>1]);
//
        $user = new User();
        $user->name = "Ricardo";
        $user->lastName="Martinez";
        $user->phone="7784595";
        $user->direction="cbba-Punata";
        $user->ci="12345672";
        $user->email="ricardo@gmail.com";
        $user->userName="ricardo";
        $user->password=bcrypt("ricardo");
        //$user->	spending_units_id=1;
        $user->save();
        $user->roles()->attach(1,['spending_unit_id'=>1,'spending_unit_status'=>1]);

        $user = new User();
        $user->name = "Daniela";
        $user->lastName="Montecinos";
        $user->phone="7522254";
        $user->direction="cbba-Tarata";
        $user->ci="12345673";
        $user->email="dani@gmail.com";
        $user->userName="danii";
        $user->password=bcrypt("danii");
        //$user->administrative_units_id=3;
        $user->save();
        $user->roles()->attach(2,['administrative_unit_id'=>3,'administrative_unit_status'=>1]);

        $user = new User();
        $user->name = "Nicole";
        $user->lastName="Mejia";
        $user->phone="7741471";
        $user->direction="cbba-Quillacollo";
        $user->ci="12345674";
        $user->email="nicole@gmail.com";
        $user->userName="nicol";
        $user->password=bcrypt("nicol");
        //$user->	spending_units_id=2;
        $user->save();
        $user->roles()->attach(1,['spending_unit_id'=>2,'spending_unit_status'=>1]);

        $user = new User();
        $user->name = "Juan Carlos";
        $user->lastName="Rosas";
        $user->phone="7744885";
        $user->direction="cbba-cercado";
        $user->ci="12345675";
        $user->email="juan10@gmail.com";
        $user->userName="juan10";
        $user->password=bcrypt("juan10");
        //$user->	spending_units_id=3;
        $user->save();
        $user->roles()->attach(1,['spending_unit_id'=>3,'spending_unit_status'=>1]);
    }
}
