<span class="fw-bold">Nombre:</span> {{ $credit->client->id }} - {{ $credit->client->name }} {{ $credit->client->last_name }} {{ $credit->client->second_last_name }}
<br> <span class="fw-bold">RFC:</span>  {{ $credit->client->rfc }}
<br><span class="fw-bold">Organización:</span>  {{ $credit->client->agreement->name }}
<br><span class="fw-bold">Tel:</span>  {{ $credit->client->cellphone }}
<br><br>
<span class="fw-bold">Producto:</span> {{ $product->alias }}
<br><span class="fw-bold">Monto:</span> {{ format_price($credit->applied_import) }}
<br><span class="fw-bold">Plazo:</span> {{ format_price($credit->applied_term) }}
<br><span class="fw-bold">Pago:</span> {{ format_price($credit->applied_payment) }}
<br><span class="fw-bold">Periodicidad:</span> {{ $periodicity }}
<br><span class="fw-bold">Tipo de crédito:</span> {{ $tipoCredito->alias}}
<br><span class="fw-bold">Compra cartera:</span> {{ $getCompracartera != null ?  format_price($credit->ammount) : null }}

<input type="hidden" id="solicitud_client_name" value="{{ $credit->client->name }} {{ $credit->client->last_name }} {{ $credit->client->second_last_name }}">
<input type="hidden" id="solicitud_history_id" value="{{ $history->id }}">
