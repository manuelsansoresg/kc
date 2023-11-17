<div class="row">
    <div class="text-center">
        @foreach ($banks as $bank)
           <div class="col-12 mt-3">
            <a  onclick="changeCreditBank({{ $credit->id }}, {{ $bank->id }})" class="btn btn-primary btn-sm btn-block-bank" style="cursor: pointer">{{ $bank->name }}</a>
           </div>
        @endforeach
        
    </div>
    <div class="col-12 text-center mt-3">
        <a  onclick="showReportOtherBanks()" class="btn btn-secondary btn-sm btn-block-bank" style="cursor: pointer">No veo mi banco</a>
    </div>
</div>