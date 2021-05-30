
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>UMSS Cotización</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <style>
    body{
        font-size: 10px;
    }
     .title-left{
         text-transform:uppercase;
         font-size: 10px;
     }
     .contenido{
         width: 100%;
         display: flex;
         justify-content: space-between;
     }
     .izquierda{
         width: 200px;
     }
     .derecha{
        width: 200px;
        padding-left: 425px;
        font-size: 9px;
     }
     .title{
         text-align: center;
         font-family: sans-serif;
         font-weight:400;
     }
     .principal{
         margin-top: 20px;
     }
     .razon-social{
        display: flex;
        padding-bottom: 0px;
        margin-bottom: 0px;
     }
     .fecha-derecha{
        padding-left: 450px;
        padding-bottom: 0px;
        margin-bottom: 0px;
     }
    .bajar{
        padding-top: 15px;
        padding-bottom: 0px;
        margin-bottom: 0px;
    }
    .table{
        position: relative;
        top: -30px;
    }
    td{
        height: 20px;
    }
    .celdaPers {
        height: 50px;
    }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <div class="contenido">
                <div class="izquierda title-left">universidad mayor de sam simón facultad de {{$facultad->nameFacultad}} aquisiciones</div>
                <div class="derecha"><p>Cochabamba-Bolivia</p></div>
            </div>
            <h5 class="title">SOLICITUD DE COTIZACIÓN</h5>
        </header>
        <main class="principal">
            <div class="razon-social">
                <p>Razón social:..............................................</p>
                <p class="fecha-derecha">Fecha: {{$fecha=date("d")."/".date("m")."/".date("Y")}} </p>
                <p class="bajar">Agradecemos a Uds. cotizamos, los articulos que a continuación se detallan. Luego de este formulario debe devolverse en sobre cerrado debidamente FIRMADO Y SELLADO (Favor especificar Marca, Modelo, Industria).</p>
            </div>
            <table class="table table-sm table-bordered text-center">
                <thead class="thead-light">
                    <tr>
                        <th width="4%">N&#176;</th>
                        <th width="6%">Cantidad</th>
                        <th width="10%">Unidad</th>
                        <th width="53%">DETALLE</th>
                        <th width="10%">Unitario</th>
                        <th width="17%">Total</th>
                    </tr>
                </thead>
               <tbody>
               {{$index=0}}
                @foreach($details as $detail)
                    <tr>
                        <th>{{$index=$index+1}}</th>
                        <td>{{$detail->amount}}</td>
                        <td>{{$detail->unitMeasure}}</td>
                        <td>{{$detail->description}}</td>
                        <td> </td>
                        <td> </td>
                    </tr>
                @endforeach
                    <tr class="table-active">
                        <td>Total </td>
                        <td colspan="3"> </td>
                        <td> </td>
                        <td> </td>
                    </tr>
                </tbody>
            </table>
            <table class="table table-sm table-bordered text-center">
                <thead class="thead-light">
                    <tr>
                        <th width="4%">N&#176;</th>
                        <th width="24%">Marca</th>
                        <th width="24%">Modelo</th>
                        <th width="24%">Industria</th>
                        <th width="24%">Tiempo de Garantia</th>
                    </tr>
                </thead>
               <tbody>
               {{$index=0}}
                @foreach($details as $detail)
                    <tr>
                        <th>{{$index=$index+1}}</th>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <table  class="table table-sm table-bordered">
                <thead class="thead-light">
                    <tr>
                        <th colspan="2" class="text-center">A PARTIR DE LA CONTIZACIÓN, DATOS A SER LLENADOS POR EL PROVEEDOR</th>
                    </tr>
                </thead>
               <tbody>
                    <tr>
                        <td class="celdaPers">Validez de oferta:</td>
                        <td class="celdaPers">Tiempo de entrega:</td>
                    </tr>
                    <tr>
                        <td class="celdaPers">N&#176; de NIT:</td>
                        <td class="celdaPers">Teléfono:</td>
                    </tr>
                    <tr>
                        <td class="celdaPers">Nombre y firma:</td>
                        <td class="celdaPers">Sello:</td>
                    </tr>
                    <tr>
                        <td class="celdaPers">Forma de pago:</td>
                        <td class="celdaPers"></td>
                    </tr>
               </tbody>
            </table>
        </main>
    </div>
</body>
</html>
