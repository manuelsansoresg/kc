@extends('layouts.admin')
@section('title', 'Resultado busqueda')

@section('content')


    <div class="nk-content">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="components-preview wide-md mx-auto">
                        <div class="nk-block-head nk-block-head-lg wide-sm">
                            <div class="nk-block-head-content">

                                <h3 class="nk-block-title page-title">Resultado busqueda</h3>

                            </div>

                        </div><!-- .nk-block-head -->
                        <div class="nk-block nk-block-lg ">
                            <div class="card card-bordered card-preview py-5">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-12">
                                            <table id="dt-search-user" class="nowrap nk-tb-list nk-tb-ulist mt-4"
                                                style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Nombre</th>
                                                        <th>Teléfono</th>
                                                        <th>Origen</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>

                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection
