<div class="row">
    <div class="col-6">
        <table class="table table-striped">
            @if ($type == 1)
            <tr>
                <td>Estatus envío S2</td>
                <td>
                    @if ($isCreditKaax == 0)
                        fail
                        @else
                        Ok
                    @endif
                </td>
            </tr>
            @else
            <tr>
                <td>Activación en S2</td>
                <td>
                    @if ($$credit->credit_s2_active == 1)
                    Ok
                        @else
                        fail  
                    @endif
                </td>
            </tr>
            @endif
            
        </table>
    </div>
</div>