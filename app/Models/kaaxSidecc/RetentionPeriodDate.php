<?php

namespace App\Models\kaaxSidecc;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Client;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

class RetentionPeriodDate extends Model
{
    use HasFactory;

    protected $connection = 'kaax_sidecc';

    protected $table = 'retention_period_dates';

    /**
     * getByPaymentbyAgreement
     *
     * @param  mixed $agreement_id
     * @return void
     */
    public static function getByPaymentbyAgreement($agreement_id)
    {
        $set_agreement = Agreement::find($agreement_id);
        $get_period = null;

        if ($set_agreement !== null) {
            $payment_type = ($set_agreement === null) ? 1 : $set_agreement->periocidad_id;

            $fecha_actual = date('Y-m-d');
            $fecha_resta = date('Y-m-d', strtotime($fecha_actual . '+ 5 days'));

            $get_period = RetentionPeriodDate::where('payment_type', $payment_type);

            $get_period->where('retention_date', '<=', $fecha_resta);
            $get_period->limit(5);
            $get_period = $get_period->orderBy('retention_date', 'DESC')->get();
        }

        return $get_period;
    }

    //obtiene 2 periodos pasados 2 3 futuros
    public static function getPostandFutureDates($agreement_id, $typePperiod = false)
    {
        $set_agreement    = Agreement_setcredit::where('agreements_id', $agreement_id)->latest()->first();
        $get_period       = null;
        $getPeriodFuture  = null;

        if ($set_agreement !== null) {
            $payment_type = ($set_agreement === null) ? 1 : $set_agreement->tipo_pago_id;
            if ($typePperiod === false) {
                $fecha_actual = date('Y-m-d');
                $fecha_resta = date('Y-m-d', strtotime($fecha_actual . '+ 5 days'));

                $getPeriodPast = RetentionPeriodDate::where('payment_type', $payment_type);

                $getPeriodPast->where('retention_date', '<=', $fecha_resta);
                $getPeriodPast->limit(5);
                $getPeriodPast = $getPeriodPast->orderBy('retention_date', 'DESC')->get();
                return $getPeriodPast;
            }

            $fecha_actual   = date('Y-m-d');
            $fecha_suma    = date('Y-m-d', strtotime($fecha_actual . '+2 days'));

            $getPeriodPast = RetentionPeriodDate::where('payment_type', $payment_type);
            $getPeriodPast->where('retention_date', '<=', $fecha_suma);
            $getPeriodPast->limit(5);
            $getPeriodPast = $getPeriodPast->orderBy('retention_date', 'DESC')->get();

            $fecha_resta    = date('Y-m-d', strtotime($fecha_actual . '- 3 days'));
            $getPeriodFuture     = RetentionPeriodDate::where('payment_type', $payment_type);
            $getPeriodFuture->where('retention_date', '>=', $fecha_resta);
            $getPeriodFuture->limit(6);
            $getPeriodFuture     = $getPeriodFuture->orderBy('retention_date', 'ASC')->get();
        }
        return array('getPeriodPast' => $getPeriodPast, 'getPeriodFuture' => $getPeriodFuture);
        //dd($get_period, $getPeriodPast);
    }

    public static function getByPaymentType($agreement_id)
    {
        $set_agreement = Agreement_setcredit::where('agreements_id', $agreement_id)->latest()->first();
        $get_period = null;

        if ($set_agreement !== null) {
            $payment_type = ($set_agreement === null) ? 1 : $set_agreement->tipo_pago_id;

            $fecha_actual = date('Y-m-d');
            $fecha_resta = date('Y-m-d', strtotime($fecha_actual . '- 5 days'));

            $get_period = RetentionPeriodDate::where('payment_type', $payment_type);
            $get_period->where('retention_date', '<=', $fecha_resta);
            $get_period->limit(5);
            $get_period = $get_period->orderBy('retention_date', 'DESC')->get();
        }

        return $get_period;
    }

    public static function getSuggestedDatesLast($paymentType, $agreement_id, $limit_position = false)
    {
        $currentDate = date('Y-m-d');
        //$twentyDaysAgo = date('Y-m-d', strtotime($currentDate . '- 45 days'));

        $position = Collection::where('agreement_id', $agreement_id)->orderBy('id', 'DESC')->limit(1)->first();
        $retention_period_id = $position->retention_period_id + 1;
        $suggestedDates = RetentionPeriodDate::find($retention_period_id);
        return $suggestedDates;
        
    }

    public static function getSuggestedDates($paymentType, $agreement_id, $limit_position = false)
    {
        $currentDate = date('Y-m-d');
        $twentyDaysAgo = date('Y-m-d', strtotime($currentDate . '- 45 days'));

        $position = Collection::where('agreement_id', $agreement_id)->count();
        $total = $position == 0 ? 0 : $position;
        $suggestedDates = RetentionPeriodDate::where('payment_type', $paymentType)
            ->where('retention_date', '>=', $twentyDaysAgo)
            ->limit(10)->get();
        if ($limit_position == false) {
            return  isset($suggestedDates[$total])?$suggestedDates[$total]: null;
        }
        return $suggestedDates;
    }

    

    public static function get_suggested_dates($payment_type)
    {
        $fecha_actual = date('Y-m-d');
        $fecha_diez_dias = date('Y-m-d', strtotime($fecha_actual . '- 20 days'));

        return RetentionPeriodDate::where('payment_type', $payment_type)
            ->where('retention_date', '>=', $fecha_diez_dias)
            ->limit(10)->get();
    }

    public static function generateRetentionDates($retention_date, $client_id)
    {
        $client = Client::find($client_log->log_id);
        $credit_info = $client->clientCreditInfo;

        $retention_dates = RetentionPeriodDate::get_payment_dates(
            $request->retention_date,
            $client->tipo_pago,
            $credit_info->plazo_quincenas
        )->toArray();
        $payment_id = null;
        foreach ($payments->result() as $payment) {
            $payment_insert = [
                'retention_period_id' => $retention_dates[$payment->payment_number - 1]['id'],
                'fecha_inicio' => $retention_dates[0]['retention_date'],
                'fecha_termino' => $retention_dates[$client->plazo_quincenas - 1]['retention_date']
            ];

            $get_payment = Payment::find($payment->id);
            $get_payment->fill($payment_insert);

            if ($payment->payment_number == 1) {
                $payment_id = $payment->id;
            }
        }

        // Se debe almacenar en centavos..
        $descuento = $credit_info->descuento * 100;
        $get_payment = Payment::find($payment_id);
        if ($get_payment !== null) {
            $data = [
                'payment_id' => $payment_id,
                'tipo_movimiento' => 1,
                'saldo' => ($descuento * $credit_info->plazo_quincenas) - $descuento,
                'pagado' => $descuento,
                'pago_acumulado' => $descuento,
                'estatus' => 3
            ];

            $payment = new Payment($data);
            $payment->save();
        }
    }

    public static function get_payment_dates($first_retention_date, $payment_type, $plazo_quincenas)
    {
        return RetentionPeriodDate::where('payment_type', $payment_type)
            ->where('retention_date', '>=', $first_retention_date)
            ->limit($plazo_quincenas)
            ->get();
    }

    public function collection()
    {
        return $this->hasMany(Collection::class);
    }
}

