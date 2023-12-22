<div class="modal fade " id="modal-product" tabindex="-1" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content bg-dark"><a href="#" class="close" data-bs-dismiss="modal"><em
                    class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-lg">
                <form action="" id="frm-modal-product">
                    <div id="content-product" class="text-white">
                        <h6 class="text-primary">Selecciona el o los créditos vigentes que quieres reducir para que los(s) podamos comparar con las mejores opciones disponibles.</h6>
                    </div>

                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Crédito(s) actual(es).</label>
                        <select class="form-select select2multiple" multiple="multiple" name="products[]"   data-search="on">
                            @foreach ($financial_products as $product)
                            <option value="{{ $product->id }}"> {{ $product->commercial_name}} - {{ $product->name }} </option>
                        @endforeach
                        </select>
                      </div>
                    <div class="col-12 text-center mt-5">
                        <a href="#" class="btn btn-outline-secondary" onclick="cancelModalProduct()">No veo mi crédito</a>
                        <a href="#" class="btn btn-outline-secondary" onclick="continueModalProduct()">Continuar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>