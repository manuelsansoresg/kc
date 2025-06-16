<span>
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
    <br><span class="fw-bold">Asesor:</span> {{ $getAsesor != null ? $getAsesor->name.' '.$getAsesor->last_name.' '.$getAsesor->second_last_name : null}}
    <br><span class="fw-bold">Origen:</span> {{ $origin }}
    <br><span class="fw-bold">Etiquetas:</span> {{ $tags }}
    <br><span class="fw-bold">Ultimo comentario:</span> {{ $lastComment!= null ? $lastComment->comment : null }}
    <hr>
    <span class="fw-bold"> Documentos:</span>

    <table class="table table-borderless">
        @foreach ($files as $file)
        <tr class="">
            <td class="">
                <a href="{{ asset($path.'/'.$file['name']) }}" target="_blank">{{ $file['name_template'] }}</a>
            </td>

        </tr>
        @endforeach
    </table>

    <hr>
    <br>

    <br><a href="/panel/credit/{{ $credit->id }}">Ver crédito <i class="fa-solid fa-arrow-up-right-from-square"></i></a>
    <br><a href="/panel/client/{{ $client->id }}">Ver cliente <i class="fa-solid fa-arrow-up-right-from-square"></i></a>
    <br><a href="/https://manychat.com/fb861553/chat/">Chatear con cliente <i class="fa-solid fa-arrow-up-right-from-square"></i></a>
    
</span>