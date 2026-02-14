<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Members extends Model
{
    use HasFactory;

    public static function booted()
    {
        static::created(function ($user) {
            $user->card_number = self::generateCardNo($user->id);
            $user->save();

        });
    }

    /**
     * generateCardNo
     *
     * @param mixed id
     *
     * @return void
     */
    public static function generateCardNo($id)
    {

        if (strlen($id) == 1) {
            return "M0000" . $id;
        } else if (strlen($id) == 2) {
            return "M000" . $id;
        } else if (strlen($id) == 3) {
            return "M00" . $id;
        } else if (strlen($id) == 4) {
            return "M0" . $id;
        } else if (strlen($id) == 5) {
            return "M" . $id;
        }

    }
}
