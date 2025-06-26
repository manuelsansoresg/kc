@extends('layouts.admin')
@section('title', 'Mis prestamos')

@inject('MCrmStatusListKaaxSidecc', 'App\Models\kaaxSidecc\CrmStatusListKaaxSidecc')
@inject('MCollection', 'App\Models\kaaxSidecc\Collection')
@inject('MInvestor', 'App\Models\Investor')
@inject('MCredit', 'App\Models\Credit')

@section('content')
    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body ">
                    <div class="nk-block-head nk-block-head-sm">
                        <div class="nk-block-between">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title">Mis prestamos</h3>
                                <div class="nk-block-des text-soft">
                                    <nav>
                                        <ul class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="/panel/home">Inicio</a></li>
                                            <li class="breadcrumb-item ">KC - Wallet</li>
                                            <li class="breadcrumb-item active">Mis prestamos</li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card card-bordered card-preview py-3 px-3">
                        
                        <table class="datatable-init nowrap table">
                            <thead>
                                <tr>
                                    <th>Crédito</th>
                                    <th></th>
                                    <th>Estatus</th>
                                    <th data-priority="1">Prestado</th>
                                    <th>Total cobrado</th>
                                    <th>Capital recuperado</th>
                                    <th>Interés cobrado*</th>
                                    <th>Capital pendiente</th>
                                    <th>Interés proyectado*</th>
                                    <th>Comisión KC</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                <tr>
                                    <td>{{ $item['id'] }}</td>
                                    <td>{!! $item['action'] !!}</td>
                                    <td>{{ $item['status'] }}</td>
                                    <td>{{ $item['importe'] }}</td>
                                    <td>{{ $item['pagado'] }}</td>
                                    <td>{{ $item['capital_recuperado'] }}</td>
                                    <td>{{ $item['interes_cobrado'] }}</td>
                                    <td>{{ $item['capital_pendiente'] }}</td>
                                    <td>{{ $item['interes_proyectado'] }}</td>
                                    <td>{{ $item['comision_kc'] }}</td>
                                    <td></td>
                                </tr>
                                @endforeach

                            </tbody>
                           
                        </table>

                        
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
