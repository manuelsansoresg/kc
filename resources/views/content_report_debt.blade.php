@extends('layouts.report')
@section('title', 'Reporte')

@section('header')
    @if (!isset($_GET['is_app']))
        @include('layouts.content_report_nav')
    @endif
@endsection
@inject('current_financial_product', 'App\Models\CurrentFinancialProduct')
@inject('m_financial_product', 'App\Models\FinancialProduct')
@php
$chart1 = isset($new_financials[0]) ? $new_financials[0] : null;
$chart2 = isset($new_financials[1]) ? $new_financials[1] : null;
$chart3 = isset($new_financials[2]) ? $new_financials[2] : null;
$chart4 = $my_product_financial;
@endphp
{{-- {{ dd($chart1, $chart2, $chart3, $chart4) }}  --}}


@section('add_script')
    @include('layouts.script_report')
@endsection
