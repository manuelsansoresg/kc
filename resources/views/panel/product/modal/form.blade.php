@inject('c_product', 'App\Models\CProduct')
@inject('c_service', 'App\Models\CService')
@php
    $products   = $c_product->getAll();
    $services   = $c_service->getAll();
@endphp

<div class="modal fade" id="modal-product" tabindex="-1" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content"><a href="#" class="close" data-bs-dismiss="modal"><em
                    class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="title" id="product-title"></h5>

                <form method="post" id="frm-product" action="">
                    @csrf
                    <div class="row gy-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Alias</label>
                                <div class="form-control-wrap">
                                   <input type="text" name="alias" id="product-alias" class="form-control">
                                </div>
                            </div>
                        </div>
                       
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Servicio</label>
                                <div class="form-control-select">
                                    <select
                                        name="c_service_id"
                                        class="form-control" 
                                        id="c_service_id">
                                        <option value="">Selecciona una opción</option>
                                        @foreach ($services as $service)
                                            <option value="{{ $service->id }}">{{ $service->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Comentario</label>
                                <div class="form-control-wrap">
                                    <textarea name="comment" id="comment" cols="30" rows="4" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group"><label class="form-label">Status</label>
                                <div class="form-control-select">
                                    <select
                                        name="status"
                                        class="form-control" 
                                        id="status" >
                                        <option value="">Selecciona una opción</option>
                                        <option value="1">Activo</option>
                                        <option value="0">Inactivo</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="product_id" name="product_id">
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