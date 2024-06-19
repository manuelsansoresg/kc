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
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card card-bordered card-preview">
                        <table class="table table-tranx">
                            <thead>
                                <tr class="tb-tnx-head">
                                    <th class="tb-tnx-id"><span class="">Crédito</span></th>
                                    <th class="tb-tnx-info"><span class="tb-tnx-desc d-none d-sm-inline-block"><span>Estatus</span></span>
                                        <span class="tb-tnx-date d-md-inline-block d-none"><span
                                                class="d-md-none"></span>
                                                <span class="d-none d-md-block"><span>Importe prestado</span><span>Pagado</span></span></span></th>
                                    <th class="tb-tnx-amount"><span class="tb-tnx-total">Capital pendiente</span><span
                                            class="tb-tnx-status d-none d-md-inline-block">Comisiones</span></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($getInvestorCredits != null)
                                    @foreach ($getInvestorCredits as $getInvestorCredit)
                                        @php
                                            $getCollection   = $MCollection::where('kc_credit_id',  $getInvestorCredit->credit_id)->first();
                                            $creditId        = $getInvestorCredit->id;
                                            $valorImporte    = null;
                                            $valorPagado     = null;
                                            $valorPorPagar   = null;
                                            $valorComisiones = null;
                                            $valorStatus     = 'Pendiente';
                                            if ($getCollection != null) {
                                                $percentage      = $getInvestorCredit->percentage / 100;
                                                $getStatus       = $MCrmStatusListKaaxSidecc::getStatus($getCollection->status);
                                                $getInvestor     = $MInvestor::find($getInvestorCredit->investor_id);
                                                $getCredit       = $MCredit::find($getInvestorCredit->credit_id);
                                                $importe         = $getInvestorCredit->import ;
                                                $pagado          = $getInvestorCredit->total_collected;
                                                $porPagar        = $getInvestorCredit->placed_capital;
                                                $comisiones      = $getInvestorCredit->commission_amount;
                                                
                                                $valorImporte    = format_price($importe);
                                                $valorPagado     = format_price($pagado);
                                                $valorPorPagar   = format_price($porPagar);
                                                $valorComisiones = format_price($comisiones);
                                                $valorStatus     = null;
                                            }
                                        @endphp
                                        
                                        <tr class="tb-tnx-item">
                                            <td class="tb-tnx-id"><a href="#"><span> {{ $creditId }} </span></a></td>
                                            <td class="tb-tnx-info">
                                                <div class="tb-tnx-desc">
                                                    {{ $valorStatus }}
                                                    </span>
                                                </div>
                                                <div class="tb-tnx-desc"><span class="amount"> {{ $valorImporte }}  </span><span
                                                        class="amount">{{ $valorPagado }} </span></div>
                                            </td>
                                            <td class="tb-tnx-info">
                                                <div class="tb-tnx-desc"><span class="amount"> {{ $valorPorPagar  }}  </span></div>
                                                <div class="tb-tnx-status">
                                                
                                                    <span class="amount"> {{ $valorComisiones }}  </span>
                                                    
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
