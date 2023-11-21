<div class="modal fade " id="modal-bank" tabindex="-1" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content bg-dark"><a href="#" class="close" data-bs-dismiss="modal"><em
                    class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                
                <div class="text-center">
                    <p class="mt-3 text-bank">Este crédito sólo se puede tramitar si recibes tu nómina en alguno de los siguientes bancos.</p>
                    <p class="text-bank">Si vez tu banco, selecciónalo:</p>
                </div>
                <div id="content-bank">

                </div>
                <div id="new_banks" class="mt-5" style="display: none">
                    <p>Selecciona tu banco en la siguiente lista</p>
                    <select name="" id="report-bank-id" class="form-control">
                        <option value=""> Selecciona tu banco </option>
                        @foreach ($banks as $bank)
                            <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 text-center mt-5">
                    <a onclick="changeCreditBank({{ $credit->id }}, 99)"class="btn btn-outline-secondary">Cerrar</a>
                    <a  onclick="changeCreditBank({{ $credit->id }}, null)" class="btn btn-outline-primary ml-4">Guardar</a>
                </div>
            </div>
        </div>
    </div>
</div>