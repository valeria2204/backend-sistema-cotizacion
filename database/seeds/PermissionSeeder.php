<?php

use Illuminate\Database\Seeder;
use App\Permission;
class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //unidad de gasto
        $permiso = new Permission();
        $permiso->namePermission ="Solicitu de aquicición";
        $permiso->description = "Puede ver las solicitudes de adquicicion y poder verlas";
        $permiso->url = "/SolicitudesDeAdquisicion";
        $permiso->save();
        $permiso2 = new Permission();
        $permiso2->namePermission ="Agregar detalle solictud";
        $permiso2->description = "Puede agragar detalles a la solicitud";
        $permiso2->url = "/AgregarDetalleSolictud";
        $permiso2->save();
        //unidad administrativa
        $permiso3 = new Permission();
        $permiso3->namePermission ="Ver las solicitudes de adquisición";
        $permiso3->description = "Se podra ver la solicitudes de adquisición que pertenecen a esa unidad administrativa";
        $permiso3->url = "/SolicitudesDeAdquisicionAdmin";
        $permiso3->save();
        $permiso4 = new Permission();
        $permiso4->namePermission ="Enviar el correo de contización";
        $permiso4->description = "Puede enviar el correo para cotizar la solicitud";
        $permiso4->url = "/EnviarCotizacion";
        $permiso4->save();
        $permiso5 = new Permission();
        $permiso5->namePermission ="Ver a detalle la solicitud de contización";
        $permiso5->description = "Puede ver a detalle la solicitud de adquisición";
        $permiso5->url = "/DetalleSolicitud/:id";
        $permiso5->save();
        $permiso6 = new Permission();
        $permiso6->namePermission ="Todo sobre monte límite";
        $permiso6->description = "Puede ver los montos límites definidos, y poder actualizarlo";
        $permiso6->url = "/montoLimite";
        $permiso6->save();
        //administrador del sistema
        $permiso7 = new Permission();
        $permiso7->namePermission ="Registrar unidades administrativas";
        $permiso7->description = "Puede ver las unidades administrativas y resgistrar nuevas unidades administrativas";
        $permiso7->url = "/UnidadesAdministrativas";
        $permiso7->save();
        $permiso7 = new Permission();
        $permiso7->namePermission ="Registrar unidades de gasto";
        $permiso7->description = "Registrar nuevas unidades de gasto";
        $permiso7->url = "/unidadesDeGasto";
        $permiso7->save();
        $permiso7 = new Permission();
        $permiso7->namePermission ="Registrar usuarios";
        $permiso7->description = "Registrar nuevos usuarios";
        $permiso7->url = "/user";
        $permiso7->save();
    }
}
