@extends('layouts.template_email')

@section('content')
<table style="width:100%;max-width:620px;margin:0 auto;background-color:#ffffff;">
    <tbody>
          <tr>
            <td style="padding: 30px 30px 15px 30px;">
                <h2 style="font-size: 18px; color: #6576ff; font-weight: 600; margin: 0;">Tus fondos están listos para ser prestados.</h2>
            </td>
        </tr>
        <tr>
            <td style="padding: 0 30px 20px">
                <p style="margin-bottom: 10px;">Hola {{$name}}.</p>
                Hemos validado tus fondos con éxito. Para prestarlos, tienes que ir a tu cuenta y en la sección de Resumen presiona "Prestar". No dudes en consultarnos por cualquier duda.
            </p>
               <br><br>
                                                        
                   
                <a href="{{$link_account}}" style="background-color:#6576ff;border-radius:4px;color:#ffffff;display:inline-block;font-size:13px;font-weight:600;line-height:44px;text-align:center;text-decoration:none;text-transform: uppercase; padding: 0 30px">Ir a PRestar</a>
                   
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