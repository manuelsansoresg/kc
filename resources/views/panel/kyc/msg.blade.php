<div clas="table-responsive" style="overflow: auto">
    <table class="table">
        @foreach ($data_array as $key =>  $row)
            <tr>
              <td> {{ $key }} </td>
              @if ($key != 'datosDocProbatorio')
                <td>  {{ json_encode($row) }} </td>
              @endif
            </tr>
            
           
        @endforeach
    </table>
</div>