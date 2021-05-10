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
        $user->name = "tom";
        $user->lastName="gato malo";
        $user->phone="64906568";
        $user->direction="cbba-sacaba";
        $user->ci="96523140";
        $user->email="tom@gmail.com";
        $user->userName="tom";
        $user->password=bcrypt("tom");
        $user->save();
        $user->roles()->attach([1,2]);

        $user = new User();
        $user->name = "jerry";
        $user->lastName="raton escurridiso";
        $user->phone="64906569";
        $user->direction="cbba-sacaba";
        $user->ci="96523160";
        $user->email="jerry@gmail.com";
        $user->userName="jerry";
        $user->password=bcrypt("jerry");
        $user->save();
        $user->roles()->attach(2);

        $user = new User();
        $user->name = "admin";
        $user->lastName="sistema";
        $user->phone="64906868";
        $user->direction="cbba-sacaba";
        $user->ci="96523240";
        $user->email="admin@gmail.com";
        $user->userName="admin";
        $user->password=bcrypt("admin");
        $user->save();
        $user->roles()->attach(3);
    }
}
