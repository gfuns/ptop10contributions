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
        return $this->repayment->sum("amount");
    }

    public function balance()
    {
        $totalPaid = $this->repayment->sum("amount");

        return ($this->amount - $totalPaid);
    }
}
