<div clas="table-responsive" style="overflow: auto">
    <table class="table">
        @foreach ($data_array as $key =>  $row)
        @php
            $key = trim($key);
            $new_key = null;
            $new_row = null;
            $i_error = false;
           try {
            if (
                  $key != 'datosDocProbatorio'
                  && $key != 'codigoValidacion'
                  && $key != 'docProbatorio'
                  && $key != 'estatusCurp'
                  && $key != 'codigoMensaje'
                  && $key != 'claveMensaje'
                  && $key != 'estatus'
                  && $key != 'cic'
                  && $key != 'numeroEmision'
                  && $key != 'distritoFederal'
                  && $key != 'distritoLocal'
                  && $key != 'ocr'
                  && $key != 'anioRegistro'
                  && $key != 'anioEmision'
                  && $key != 'tipoPersona'
                  && $key != 'claveMensaje'
                  ) {
                    $new_key = $key;
                    $new_row =  json_encode($row) ;
                  }
           } catch (\Exception $e) {
            $i_error = true;
           }
                
        @endphp
        @if ($i_error == false && $new_key != null)
            
        <tr>
          <td> 
           
            {{ $new_key }} 
          </td>
          
            <td>  {{ $new_row }}  </td>
        </tr>
        @endif
            
           
        @endforeach
    </table>
</div>