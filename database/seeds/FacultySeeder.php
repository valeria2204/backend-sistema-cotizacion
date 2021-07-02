<?php

use Illuminate\Database\Seeder;
use App\Faculty;
class FacultySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faculty= new Faculty();
        $faculty->nameFacultad = "Ciencias y Tecnología";
        $faculty->inUse = 1;
        $faculty->save();

        $faculty1= new Faculty();
        $faculty1->nameFacultad = "Ciencias Jurídicas y Políticas";
        $faculty1->inUse = 1;
        $faculty1->save();

        $faculty2= new Faculty();
        $faculty2->nameFacultad = "Ciencias Económicas";
        $faculty2->inUse = 1;
        $faculty2->save();

        $faculty3= new Faculty();
        $faculty3->nameFacultad = "Humanidades y Ciencias de la Educación";
        $faculty3->inUse = 1;
        $faculty3->save();

        $faculty3= new Faculty();
        $faculty3->nameFacultad = "Arquitectura y Ciencias del Hábitat";
        $faculty3->inUse = 0;
        $faculty3->save();

        $faculty4= new Faculty();
        $faculty4->nameFacultad = "Medicina";
        $faculty4->inUse = 0;
        $faculty4->save();

        $faculty4= new Faculty();
        $faculty4->nameFacultad = "Odontología";
        $faculty4->inUse = 0;
        $faculty4->save();

        $faculty4= new Faculty();
        $faculty4->nameFacultad = "Ciencias Sociales";
        $faculty4->inUse = 0;
        $faculty4->save();
    }
}
