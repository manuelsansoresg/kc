<div class="modal fade" id="modal-importe" tabindex="-1" aria-modal="true" role="dialog" style="z-index: 99999999999">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content bg-dark2">
            <a href="#" class="close" data-bs-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label text-white">Importe.</label>
                    <select name="importe" id="importe" class="form-control">
                        <option value="">Selecciona una opción</option>
                        @foreach(range(5000, 100000, 5000) as $value)
                            <?php $formattedValue = number_format($value, 0, '', ''); ?>
                            <option value="{{ $formattedValue }}">
                                ${{ number_format($value) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 text-center mt-5">
                    <a href="#" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</a>
                    <a href="#" class="btn btn-outline-primary" onclick="filterImporte()">Guardar</a>
                </div>
            </div>
        </div>
    </div>
</div>
