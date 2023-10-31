<div class="modal fade" id="modal-product-fees" tabindex="-1" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content"><a href="#" class="close" data-bs-dismiss="modal"><em
                    class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="title" id="lead-note-title"></h5>

                <form method="post" id="frm-product-fees" action="">
                    @csrf
                    <div class="row gy-4">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="frm-user-admin-name">Concepto</label>
                                <div class="form-control-wrap">
                                    <input type="text" name="data[concepto]" class="form-control">
                                </div>
                            </div>
                        </div>
                        @php
                            $periodicity = config('enums.periodicity_comision');
                        @endphp
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="frm-user-admin-name">Periodicidad</label>
                                <div class="form-control-wrap">
                                    <select name="data[periodicidad]" class="form-control">
                                        <option value="">Selecciona una opción</option>
                                        @foreach ($periodicity as $key =>  $periodicity)
                                            <option value="{{ $key }}"> {{ $periodicity }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                       
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="frm-user-admin-name">Moneda</label>
                                <div class="form-control-wrap">
                                    <select name="data[moneda]" class="form-control">
                                        <option value="">Selecciona una opción</option>
                                        <option value="1">Pesos</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Valor fijo</label>
                                <div class="form-control-wrap">
                                    <ul class="custom-control-group g-3 align-center flex-wrap">
                                        <li>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" class="custom-control-input" onclick="showValorFijo(true)" id="type_active"  name="data[type]"  value="1">
                                                <label class="custom-control-label" for="type_active">Sí  </label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" class="custom-control-input" onclick="showValorFijo(false)" id="type_pending" name="data[type]" value="0">
                                                <label class="custom-control-label" for="type_pending">No</label>
                                            </div>
                                        </li>
                                    
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div id="content-valor-fijo" style="display: none">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label" for="frm-user-admin-name">Valor</label>
                                    <div class="form-control-wrap">
                                        <input type="number" name="data[valor]" class="form-control">
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        
                        <div id="content-no-valor-fijo" style="display: none">
                            <div class="form-group">
                                <label class="form-label" for="frm-user-admin-name">Porcentaje</label>
                                <div class="form-control-wrap">
                                    <input type="number" name="data[porcentaje]" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label" for="frm-user-admin-name">Referencia %</label>
                                    <div class="form-control-wrap">
                                        @php
                                            $fee_reference_percents = config('enums.fee_reference_percents');
                                        @endphp
                                        <select name="data[referencia]" class="form-control">
                                            <option value="">Selecciona una opción</option>
                                            @foreach ($fee_reference_percents as $key => $fee_reference_percents)
                                                <option value="{{ $key }}"> {{ $fee_reference_percents }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <input type="hidden" id="financial_product_id" name="data[financial_product_id]">
                        <input type="hidden" name="data[type]" id="comision_type">
                        
                        <div class="col-12">
                            <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                <li>
                                    {{-- <a href="#" data-bs-dismiss="modal" class="btn btn-primary"></a> --}}
                                    <button class="btn btn-primary">Guardar</button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>