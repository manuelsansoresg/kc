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

                    <div class="card card-bordered card-preview">
                        
                        <table id="dt-mis-prestamos" class="nowrap nk-tb-list nk-tb-ulist" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Crédito</th>
                                    <th>Estatus</th>
                                    <th data-priority="1">Prestado</th>
                                    <th>Total cobrado</th>
                                    <th>Capital recuperado</th>
                                    <th>Interés cobrado</th>
                                    <th>Capital pendiente</th>
                                    <th>Interés proyectado</th>
                                    <th>Comisión KC</th>
                                    <th></th>
                                </tr>
                            </thead>
                           
                        </table>

                        
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
