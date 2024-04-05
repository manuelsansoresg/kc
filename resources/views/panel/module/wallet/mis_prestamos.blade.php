@extends('layouts.admin')
@section('title', 'Mis prestamos')

@section('content')
    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body ">
                    <div class="card card-bordered card-preview">
                        <table class="table table-tranx">
                            <thead>
                                <tr class="tb-tnx-head">
                                    <th class="tb-tnx-id"><span class="">#</span></th>
                                    <th class="tb-tnx-info"><span class="tb-tnx-desc d-none d-sm-inline-block"><span>Nombre</span></span>
                                        <span class="tb-tnx-date d-md-inline-block d-none"><span
                                                class="d-md-none"></span>
                                                <span class="d-none d-md-block"><span>FECHA PRÉSTAMO</span><span>CAPITAL PENDIENTE</span></span></span></th>
                                    <th class="tb-tnx-amount"><span class="tb-tnx-total">CAPITAL PRESTADO</span><span
                                            class="tb-tnx-status d-none d-md-inline-block">STATUS</span></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($collections != null)
                                    @foreach ($collections as $collection)
                                        
                                    <tr class="tb-tnx-item">
                                        <td class="tb-tnx-id"><a href="#"><span> {{ $collection->credit_id }} </span></a></td>
                                        <td class="tb-tnx-info">
                                            <div class="tb-tnx-desc"><span class="title">{{ $collection->nombre }}</span>
                                            </div>
                                            <div class="tb-tnx-date"><span class="date">  {{ $collection->fecha_cobro }}</span><span
                                                    class="date">{{ $collection->fecha_cobro }}</span></div>
                                        </td>
                                        <td class="tb-tnx-amount">
                                            <div class="tb-tnx-total"><span class="amount">{{ format_price($collection->saldo_insoluto_real) }}</span></div>
                                            <div class="tb-tnx-status">
                                            
                                                <span class="badge badge-dot bg-warning"></span>
                                                {{ isset(config('enums.status_credit')[$collection->status])? config('enums.status_credit')[$collection->status] : null }}
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
