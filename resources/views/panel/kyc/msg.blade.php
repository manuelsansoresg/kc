<div clas="table-responsive" style="overflow: auto">
    <table class="table">
        @foreach ($data_array as $key =>  $row)
            <tr>
              <td> 
                @if (
                  $key != 'datosDocProbatorio'
                  || $key != 'codigoValidacion'
                  || $key != 'docProbatorio'
                  || $key != 'datosDocProbatorio'
                  || $key != 'estatusCurp'
                  || $key != 'codigoMensaje'
                  || $key != 'claveMensaje'
                  || $key != 'codigoValidacion'
                  || $key != 'estatus'
                  || $key != 'cic'
                  || $key != 'numeroEmision'
                  || $key != 'distritoFederal'
                  || $key != 'distritoLocal'
                  || $key != 'ocr'
                  || $key != 'anioRegistro'
                  || $key != 'anioEmision'
                  || $key != 'tipoPersona'
                  || $key != 'codigoValidacion'
                  || $key != 'claveMensaje'
                  )
                {{ $key }} 
                @endif
              </td>
              @if (
                  $key != 'datosDocProbatorio'
                  || $key != 'codigoValidacion'
                  || $key != 'docProbatorio'
                  || $key != 'datosDocProbatorio'
                  || $key != 'estatusCurp'
                  || $key != 'codigoMensaje'
                  || $key != 'claveMensaje'
                  || $key != 'codigoValidacion'
                  || $key != 'estatus'
                  || $key != 'cic'
                  || $key != 'numeroEmision'
                  || $key != 'distritoFederal'
                  || $key != 'distritoLocal'
                  || $key != 'ocr'
                  || $key != 'anioRegistro'
                  || $key != 'anioEmision'
                  || $key != 'tipoPersona'
                  || $key != 'codigoValidacion'
                  || $key != 'claveMensaje'
                  )
                <td>  {{ json_encode($row) }} </td>
              @endif
            </tr>
            
           
        @endforeach
    </table>
</div>