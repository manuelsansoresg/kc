@inject('m_financial_product', 'App\Models\FinancialProduct')
<div class="user-card">
    <div class="user-info">
        <span class="tb-lead">
            @php
                $getFinancial = $m_financial_product::find($lead->financial_product_id);
                
            @endphp
            @if ($validate == false )
                <span class="text-danger">{{ $lead->name }} {{ $lead->last_name }}  </span>
            @else
                <span class="text-success">{{ $lead->name }} {{ $lead->last_name }}  </span>
            @endif
            
            
            <span class="dot dot-success d-md-none ms-1"></span>
       </span><span>{{ $lead->email }}</span>
    </div>
</div>
