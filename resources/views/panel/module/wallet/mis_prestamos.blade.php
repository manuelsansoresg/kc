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
                                                <span class="d-none d-md-block"><span>Importe Prestado</span></span></span></th>
                                    <th>
                                        <span>Pagado</span>
                                    </th>
                                    <th>
                                        <span class="tb-tnx-total">Capital pendiente</span>
                                    </th>
                                    <th>
                                        <span class="tb-tnx-total">Capital recuperado</span>
                                    </th>
                                    <th>
                                        <span class="tb-tnx-total">Interés proyectado</span>
                                    </th>
                                    <th>
                                        <span class="tb-tnx-total">Interés cobrado</span>
                                    </th>
                                    <th>
                                        <span class="tb-tnx-total">Comisión KC</span>
                                    </th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @if ($getInvestorCredits != null)
                                    @foreach ($getInvestorCredits as $getInvestorCredit)
                                        @php
                                            $getCollection   = $MCollection::where('kc_credit_id',  $getInvestorCredit->credit_id)->first();
                                            $creditId        = $getInvestorCredit->id;
                                            $valorStatus     = 'Pendiente';
                                            $importe         = $getInvestorCredit->import ;
                                            $pagado          = $getInvestorCredit->total_collected;
                                            $porPagar        = $getInvestorCredit->placed_capital;
                                            
                                            $valorImporte    = format_price($importe);
                                            $valorPagado     = format_price($pagado);
                                            $valorPorPagar   = format_price($porPagar);

                                            $interesProyectado = format_price($getInvestorCredit->total_credit  - $getInvestorCredit->import);
                                            if ($getCollection != null) {
                                                $percentage      = $getInvestorCredit->percentage / 100;
                                                $getStatus       = $MCrmStatusListKaaxSidecc::getStatus($getCollection->status);
                                                $getInvestor     = $MInvestor::find($getInvestorCredit->investor_id);
                                                $getCredit       = $MCredit::find($getInvestorCredit->credit_id);
                                                $valorStatus     = $getStatus->name;
                                            }
                                        @endphp
                                        
                                        <tr class="tb-tnx-item">
                                            <td class="tb-tnx-id"><a target="_blank" href="/panel/credit/{{ $creditId }}"><span> {{ $creditId }} </span></a></td>
                                            <td class="tb-tnx-info">
                                                <div class="tb-tnx-desc">
                                                    {{ $valorStatus }}
                                                    </span>
                                                </div>
                                                <div class="tb-tnx-desc"><span class="amount"> {{ $valorImporte }}  </span>
                                                   </div>
                                            </td>
                                            <td>
                                                <span
                                                class="amount">{{ $valorPagado }} </span>
                                            </td>
                                            <td class="tb-tnx-info">
                                                <div class="tb-tnx-desc"><span class="amount"> {{ $valorPorPagar  }}  </span></div>
                                               
                                            </td>
                                            
                                            <td class="tb-tnx-info">
                                                <div class="tb-tnx-desc"><span class="amount"> {{ format_price($getInvestorCredit->recovered_capital)  }}  </span></div>
                                               
                                            </td>
                                            <td class="tb-tnx-info">
                                                
                                                <div class="tb-tnx-desc"><span class="amount"> {{ $interesProyectado  }}  </span></div>
                                               
                                            </td>
                                            <td class="tb-tnx-info">
                                                <div class="tb-tnx-desc"><span class="amount"> {{ format_price($getInvestorCredit->profit_collected)  }}  </span></div>
                                               
                                            </td>
                                            <td class="tb-tnx-info">
                                                <div class="tb-tnx-desc"><span class="amount"> {{ format_price($getInvestorCredit->commission_amount)  }}  </span></div>
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
