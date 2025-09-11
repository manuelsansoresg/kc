@extends('layouts.template_email')

@section('content')
<table style="width:100%;max-width:620px;margin:0 auto;background-color:#ffffff;">
    <tbody>
          <tr>
            <td style="padding: 30px 30px 15px 30px;">
                <h2 style="font-size: 18px; color: #6576ff; font-weight: 600; margin: 0;"> {{ $product->alias }} entregado</h2>
            </td>
        </tr>
        <tr>
            <td style="padding: 0 30px 20px">
                <p style="margin-bottom: 10px;">Hola </p>
                Sólo te notificamos que se ha entregado un {{ $product->alias }} para:

                 <br><br>{{ $nombre_completo }}
                <br> <br>
                Si tienes alguna duda, no dudes en contactarnos a través de la sección “Ayuda” de tu panel.


                <br><br>
               <span style="font-size: 12px; color: #666666;">Puedes desactivar este tipo de notificaciones en la sección “Notificaciones” de tu panel</span>


            </p>
                   
            </td>
        </tr>
        <tr>
            <td style="padding: 0 30px">
               
               
            </td>
        </tr>
        <tr>
            <td style="padding: 20px 30px 40px">
              
            </td>
        </tr>
    </tbody>
</table>
@endsection