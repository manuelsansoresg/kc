@inject('m_tag', 'App\Models\Tag')
<div class="modal fade" id="modal-credit-tag" tabindex="-1" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content"><a href="#" class="close" data-bs-dismiss="modal"><em
                    class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="title" id="lead-note-title"></h5>

                <form method="post" id="frm-credit-tag" action="">
                    @csrf
                    @php
                        $tags = $m_tag->getByCredit();
                    @endphp
                    <div class="row gy-4">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="frm-user-admin-name">Nota</label>
                                <div class="form-control-wrap">
                                    <select class="form-select select2multiple" multiple="multiple" id="modal-credit-tag-tag" name="tags[]"  data-search="on">
                                        @foreach ($tags as $tag)
                                            <option value="{{ $tag->id }}">  {{ $tag->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <input type="hidden" id="modal-credit-credit_id" name="credit_id">
                        
                        <div class="col-12">
                            <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                <li>
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