@extends('layouts.template_email')

@section('content')
<table style="width:100%;max-width:620px;margin:0 auto;background-color:#ffffff;">
    <tbody>
          <tr>
            <td style="padding: 30px 30px 15px 30px;">
                <h2 style="font-size: 18px; color: #6576ff; font-weight: 600; margin: 0;">Tus fondos han sido depositados a tu cuenta.</h2>
            </td>
        </tr>
        <tr>
            <td style="padding: 0 30px 20px">
                <p style="margin-bottom: 10px;">Hola {{$name}}.</p>
                Tu solicitud de retiro de fondos ha sido procesada exitosamente. No dudes en consultarnos por cualquier duda.

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