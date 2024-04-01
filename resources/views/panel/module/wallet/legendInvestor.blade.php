@if ($user != null)
<h6>INSTRUCCIONES</h6>

<p> <br> <b>1- Realiza un SPEI o transferencia a la siguiente cuenta:</b>
    
    <br>Banco: {{ $user->investment_bank_name}}
    <br>Nombre: {{ $user->investment_bank_account_holder }}
    <br>CLABE:  {{ $user->investment_bank_clabe }}
    <br>Cuenta:  {{ $user->investment_bank_account_number }}

    <br><br> <b>2- Regresa a esta página después de haber hecho el pago y captura los datos:</b>
    
    <br><br> <b>IMPORTANTE:</b> No se acepta efectivo.
</p>
@endif