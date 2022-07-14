@extends('layouts.admin')
@section('title', 'Lista de usuarios')
@section('content')
    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head nk-block-head-sm">
                        <div class="nk-block-between">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title">Usuarios Admin</h3>
                                <div class="nk-block-des text-soft">
                                    <nav>
                                        <ul class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="/panel/home">Inicio</a></li>
                                            <li class="breadcrumb-item">Configuración</li>
                                            <li class="breadcrumb-item"><a href="#">Usuario</a></li>
                                            <li class="breadcrumb-item active"><a href="/panel/user/admin">Admin</a></li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                            <div class="nk-block-head-content">
                                <a class="btn btn-icon btn-primary" onclick="modalUserAdmin(1)"><em
                                        class="icon ni ni-plus"></em></a>
                            </div>
                        </div>
                    </div>
                    <div class="nk-block">
                        <div class="card card-bordered card-stretch">
                            <div class="card-body">
                                <table id="example" class="table table-striped datatable" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Usuario</th>
                                            <th>Email</th>
                                            <th>Teléfono</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $query)
                                            <tr>
                                                <td> {{ $query->name }} {{ $query->last_name }} </td>
                                                <td> {{ $query->email }} </td>
                                                <td> {{ $query->phone }} </td>
                                                <td>
                                                    <div class="drodown"><a href="#"
                                                            class="dropdown-toggle btn btn-icon btn-trigger"
                                                            data-bs-toggle="dropdown"><em
                                                                class="icon ni ni-more-h"></em></a>
                                                        <div class="dropdown-menu dropdown-menu-end">
                                                            <ul class="link-list-opt no-bdr">
                                                                <li>
                                                                    <a href="#">
                                                                        <em class="icon ni ni-focus"></em><span>Editar</span></a>
                                                                    </li>
                                                                <li>
                                                                    <a href="#">
                                                                        <em class="icon ni ni-eye"></em><span>Cambiar contraseña</span></a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('panel.modal.user.form_admin')
@endsection
