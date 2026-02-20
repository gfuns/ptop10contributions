<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberLoans extends Model
{
    use HasFactory;

    public static function booted()
    {
        static::created(function ($loan) {
            $loan->application_id = self::generateAppId($loan->id);
            $loan->save();

        });
    }

    /**
     * generateAppId
     *
     * @param mixed id
     *
     * @return void
     */
    public static function generateAppId($id)
    {

        if (strlen($id) == 1) {
            return "LOAN-0000" . $id;
        } else if (strlen($id) == 2) {
            return "LOAN-000" . $id;
        } else if (strlen($id) == 3) {
            return "LOAN-00" . $id;
        } else if (strlen($id) == 4) {
            return "LOAN-0" . $id;
        } else if (strlen($id) == 5) {
            return "LOAN" . $id;
        }

    }

    public function agent()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function guarantor()
    {
        return $this->belongsTo('App\Models\Members', 'guarantor_id');
    }

    public function member()
    {
        return $this->belongsTo('App\Models\Members', 'member_id');
    }

    public function repayment()
    {
        return $this->hasMany('App\Models\LoanRepayment', 'loan_id');
    }

    public function totalPaid()
    {
        return $this->repayment->sum("amount_paid");
    }

    public function balance()
    {
        $totalPaid = $this->repayment->sum("amount_paid");

        return ($this->amount - $totalPaid);
    }

    public function schedule()
    {
        $weeks = [
            1 => $this->first_payment_status,
            2 => $this->second_payment_status,
            3 => $this->third_payment_status,
            4 => $this->fourth_payment_status,
            5 => $this->fifth_payment_status,
            6 => $this->sixth_payment_status,
            7 => $this->seventh_payment_status,
            8 => $this->eighth_payment_status,
        ];

        foreach ($weeks as $week => $status) {
            if ($status === 'pending') {
                return $week;
            }
        }

        return 'All Paid';
    }

    public function weekInfo()
    {
        $weeks = [
            1 => $this->first_payment_status,
            2 => $this->second_payment_status,
            3 => $this->third_payment_status,
            4 => $this->fourth_payment_status,
            5 => $this->fifth_payment_status,
            6 => $this->sixth_payment_status,
            7 => $this->seventh_payment_status,
            8 => $this->eighth_payment_status,
        ];

        foreach ($weeks as $week => $status) {
            if ($status === 'pending') {
                return "Week $week";
            }
        }

        return 'All Paid';
    }

    public function dateInfo()
    {
        $weeks = [
            1 => $this->first_payment_status,
            2 => $this->second_payment_status,
            3 => $this->third_payment_status,
            4 => $this->fourth_payment_status,
            5 => $this->fifth_payment_status,
            6 => $this->sixth_payment_status,
            7 => $this->seventh_payment_status,
            8 => $this->eigth_payment_status,
        ];

        $weeksDate = [
            1 => $this->first_payment,
            2 => $this->second_payment,
            3 => $this->third_payment,
            4 => $this->fourth_payment,
            5 => $this->fifth_payment,
            6 => $this->sixth_payment,
            7 => $this->seventh_payment,
            8 => $this->eigth_payment,
        ];

        foreach ($weeks as $week => $status) {
            if ($status === 'pending') {
                return $weeksDate[$week];
            }
        }

        return 'All Paid';
    }
}
