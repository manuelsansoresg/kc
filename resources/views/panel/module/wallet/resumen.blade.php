@extends('layouts.admin')
@section('title', 'Resumen')

@section('content')

    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head nk-block-head-sm">
                        <div class="nk-block-between">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title">Resumen</h3>
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
                    <div class="nk-block nk-block-lg">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-md-6 col-lg-4">
                                    <div class="nk-wg-card is-dark card card-bordered">
                                        <div class="card-inner">
                                            <div class="nk-iv-wg2">
                                                <div class="nk-iv-wg2-title">
                                                    <h6 class="title text-white">Total disponible <em
                                                            class="icon ni ni-info"></em>
                                                    </h6>
                                                </div>
                                                <div class="nk-iv-wg2-text">
                                                    <div class="nk-iv-wg2-amount  text-white">
                                                        {{ $investor != null ? format_price($investor->total_available) : null }}
                                                        <span class="change up">
                                                            {{--  <span
                                                                class="sign"></span>3.4%</span>
                                                            </div> --}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="nk-block">
                                        <div class="row gy-gs mt-3">
                                            <div class="col-12">
                                                <div class="nk-wg-card card card-bordered h-100">
                                                    <div class="card-inner h-100">
                                                        <div class="nk-iv-wg2">
                                                            <div class="nk-iv-wg2-title">
                                                                <h6 class="title">Balance total</h6>
                                                            </div>
                                                            <div class="nk-iv-wg2-text">
                                                                @php
                                                                    $totalDisponible =
                                                                        $investor != null
                                                                            ? $investor->total_available
                                                                            : 0;
                                                                    $totalPendiente =
                                                                        $investor != null
                                                                            ? $investor->placed_capital
                                                                            : 0;
                                                                    $totalPrestable = $investor != null
                                                                            ? $investor->loan_available
                                                                            : 0;
                                                                    $total = $totalDisponible + $totalPendiente;
                                                                    $capital = $investor != null
                                                                            ? $investor->placed_capital
                                                                            : 0;
                                                                    $gananciaTotalGenerada = $investor != null ? $investor->profit_collected : 0;
                                                                @endphp

                                                                <div class="nk-iv-wg2-amount ui-v2">
                                                                    {{ format_price($total) }} </div>

                                                                <ul class="nk-iv-wg2-list">
                                                                    <li><span class="item-label">Total
                                                                            disponible</span><span
                                                                            class="item-value">{{ format_price($totalDisponible) }}</span>
                                                                    </li>
                                                                    <li><span class="item-label">Capital
                                                                            pendiente</span><span
                                                                            class="item-value">{{ format_price($totalPendiente) }}</span>
                                                                    </li>
                                                                    <li class="total"><span class="item-label">Total</span><span class="item-value">  {{ format_price($total) }}</span></li>

                                                                </ul>
                                                            </div>
                                                            <div class="nk-iv-wg2-cta"><a href="#"
                                                                    class="btn btn-primary btn-lg btn-block">Agregar
                                                                    fondos</a>
                                                                {{--  <a href="#"
                                                                    class="btn btn-trans btn-block">Deposit Funds</a> --}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- second card --}}
                                <div class="col-md-6 col-lg-4">
                                    <div class="nk-wg-card is-s1 card card-bordered">
                                        <div class="card-inner">
                                            <div class="nk-iv-wg2">
                                                <div class="nk-iv-wg2-title">
                                                    <h6 class="title">Capital pendiente <em class="icon ni ni-info"></em></h6>
                                                </div>
                                                <div class="nk-iv-wg2-text">
                                                    <div class="nk-iv-wg2-amount">{{ format_price($capital) }} {{-- <span class="change up">
                                                        <span
                                                                class="sign"></span>2.8%</span> --}}
                                                            </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="nk-block">
                                        <div class="row gy-gs mt-3">
                                            <div class="col-12">
                                                <div class="nk-wg-card card card-bordered h-100">
                                                    <div class="card-inner h-100">
                                                        <div class="nk-iv-wg2">
                                                            <div class="nk-iv-wg2-title">
                                                                <h6 class="title">Disponible para el retiro</h6>
                                                            </div>
                                                            <div class="nk-iv-wg2-text">
                                                               

                                                                <div class="nk-iv-wg2-amount ui-v2">
                                                                    {{ format_price($totalDisponible - $totalPrestable) }} </div>

                                                                <ul class="nk-iv-wg2-list">
                                                                    <li><span class="item-label">Total
                                                                            disponible</span><span
                                                                            class="item-value">{{ format_price($totalDisponible) }}</span>
                                                                    </li>
                                                                    <li><span class="item-label">Prestable</span><span
                                                                            class="item-value">{{ format_price($totalPrestable) }}</span>
                                                                    </li>
                                                                    <li class="total"><span class="item-label">Disponible para el retiro</span><span class="item-value">  {{ format_price($totalDisponible - $totalPrestable) }} </span></li>

                                                                </ul>
                                                            </div>
                                                            <div class="nk-iv-wg2-cta"><a href="#"
                                                                    class="btn btn-primary btn-lg btn-block">Retirar
                                                                    fondos</a>
                                                                {{--  <a href="#"
                                                                    class="btn btn-trans btn-block">Deposit Funds</a> --}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                {{-- third card --}}
                                <div class="col-md-6 col-lg-4">
                                    <div class="nk-wg-card is-s3  card card-bordered">
                                        <div class="card-inner">
                                            <div class="nk-iv-wg2">
                                                <div class="nk-iv-wg2-title">
                                                    <h6 class="title">Ganancia total generada <em class="icon ni ni-info"></em></h6>
                                                </div>
                                                <div class="nk-iv-wg2-text">
                                                    <div class="nk-iv-wg2-amount">{{ format_price($gananciaTotalGenerada) }} {{-- <span class="change up">
                                                        <span
                                                                class="sign"></span>2.8%</span> --}}
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
            </div>
        </div>
    </div>
    @endsection
