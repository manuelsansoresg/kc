@inject('m_tag', 'App\Models\Tag')
<div class="modal fade" id="modal-reference" tabindex="-1" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content"><a href="#" class="close" data-bs-dismiss="modal"><em
                    class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="title" id="lead-note-title"></h5>

                <form method="post" id="frm-credit-reference" action="">
                    <div class="row gy-4">
                        @csrf
                        @php
                            $last_name                  = null;
                            $second_lastname            = null;
                            $names                      = null;
                            $relationship               = null;
                            $relationship_time_years    = null;
                            $relationship_time_months   = null;
                            $cel_phone                  = null;
                            $local_phone                = null;
                            $contact_time               = null;
                            $postal_code                = null;
                            $street                     = null;
                            $home_external_number       = null;
                            $home_internal_number       = null;
                            $colony                     = null;
                            $city                       = null;
                            $state                      = null;
                            $country                    = null;
                            $note                       = null;
                        @endphp
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="frm-product-name">*Primer apellido</label>
                                <div class="form-control-wrap">
                                    <input type="text" id="last_name" name="data_reference[last_name]"
                                        class="form-control"
                                        required
                                        value="{{ $last_name }}">
                                        <label id="product-name-unique-error"
                                        class="error" style="display: none"></label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="frm-product-name">*Segundo apellido</label>
                                <div class="form-control-wrap">
                                    <input type="text" id="second_lastname" name="data_reference[second_lastname]"
                                        class="form-control"
                                        required
                                        value="{{ $second_lastname }}">
                                        <label id="product-name-unique-error"
                                        class="error" style="display: none"></label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="frm-product-name">*Nombres</label>
                                <div class="form-control-wrap">
                                    <input type="text" id="names" name="data_reference[names]"
                                        class="form-control"
                                        required
                                        value="{{ $names }}">
                                        <label id="product-name-unique-error"
                                        class="error" style="display: none"></label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="frm-product-name">Relación</label>
                                <div class="form-control-wrap">
                                    <input type="text" id="relationship" name="data_reference[relationship]"
                                        class="form-control"
                                        value="{{ $relationship }}">
                                        <label id="product-name-unique-error"
                                        class="error" style="display: none"></label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="frm-product-name">Años de relación</label>
                                <div class="form-control-wrap">
                                    <input type="number" id="relationship_time_years" name="data_reference[relationship_time_years]"
                                        class="form-control"
                                        value="{{ $relationship_time_years }}">
                                        <label id="product-name-unique-error"
                                        class="error" style="display: none"></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="frm-product-name">Meses de relación</label>
                                <div class="form-control-wrap">
                                    <input type="number" id="relationship_time_months" name="data_reference[relationship_time_months]"
                                        class="form-control"
                                        value="{{ $relationship_time_months }}">
                                        <label id="product-name-unique-error"
                                        class="error" style="display: none"></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="frm-product-name">*Tel. Celular</label>
                                <div class="form-control-wrap">
                                    <input type="number" id="cel_phone" name="data_reference[cel_phone]"
                                        class="form-control"
                                        required
                                        value="{{ $cel_phone }}">
                                        <label id="product-name-unique-error"
                                        class="error" style="display: none"></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="frm-product-name">Tel. Fijo</label>
                                <div class="form-control-wrap">
                                    <input type="number" id="local_phone" name="data_reference[local_phone]"
                                        class="form-control"
                                        value="{{ $local_phone }}">
                                        <label id="product-name-unique-error"
                                        class="error" style="display: none"></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="frm-product-name">Horario de contacto</label>
                                <div class="form-control-wrap">
                                    <input type="text" id="contact_time" name="data_reference[contact_time]"
                                        class="form-control"
                                        value="{{ $contact_time }}">
                                        <label id="product-name-unique-error"
                                        class="error" style="display: none"></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="frm-product-name">Código postal</label>
                                <div class="form-control-wrap">
                                    <input type="number" id="postal_code" name="data_reference[postal_code]"
                                        class="form-control"
                                        value="{{ $postal_code }}">
                                        <label id="product-name-unique-error"
                                        class="error" style="display: none"></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="frm-product-name">Calle</label>
                                <div class="form-control-wrap">
                                    <input type="text" id="street" name="data_reference[street]"
                                        class="form-control"
                                        value="{{ $street }}">
                                        <label id="product-name-unique-error"
                                        class="error" style="display: none"></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="frm-product-name">Número exterior.</label>
                                <div class="form-control-wrap">
                                    <input type="text" id="home_external_number" name="data_reference[home_external_number]"
                                        class="form-control"
                                        value="{{ $home_external_number }}">
                                        <label id="product-name-unique-error"
                                        class="error" style="display: none"></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="frm-product-name">Número interior</label>
                                <div class="form-control-wrap">
                                    <input type="text" id="home_internal_number" name="data_reference[home_internal_number]"
                                        class="form-control"
                                        value="{{ $home_internal_number }}">
                                        <label id="product-name-unique-error"
                                        class="error" style="display: none"></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="frm-product-name">Colonia</label>
                                <div class="form-control-wrap">
                                    <input type="text" id="colony" name="data_reference[colony]"
                                        class="form-control"
                                        value="{{ $colony }}">
                                        <label id="product-name-unique-error"
                                        class="error" style="display: none"></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="frm-product-name">Municipio</label>
                                <div class="form-control-wrap">
                                    <input type="text" id="city" name="data_reference[city]"
                                        class="form-control"
                                        value="{{ $city }}">
                                        <label id="product-name-unique-error"
                                        class="error" style="display: none"></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="frm-product-name">Estado</label>
                                <div class="form-control-wrap">
                                    <input type="text" id="state" name="data_reference[state]"
                                        class="form-control"
                                        value="{{ $state }}">
                                        <label id="product-name-unique-error"
                                        class="error" style="display: none"></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="frm-product-name">País</label>
                                <div class="form-control-wrap">
                                    <input type="text" id="country" name="data_reference[country]"
                                        class="form-control"
                                        value="{{ $country }}">
                                        <label id="product-name-unique-error"
                                        class="error" style="display: none"></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="frm-product-name">Comentario</label>
                                <div class="form-control-wrap">
                                    <textarea type="text" id="note" name="data_reference[note]"
                                        class="form-control"
                                        value="">{{ $note }}</textarea>
                                        <label id="product-name-unique-error"
                                        class="error" style="display: none"></label>
                                </div>
                            </div>
                        </div>
                     
                        <div class="col-12">
                            <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                <li>
                                    <button class="btn btn-primary">Guardar</button>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <input type="hidden" name="history_id" id="modal_history_id" value="">
                    <input type="hidden" name="reference_id" id="modal_reference_id" value="">
                </form>
            </div>
        </div>
    </div>
</div>