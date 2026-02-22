<?php
namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Members extends Model
{
    use HasFactory;

    public static function booted()
    {
        static::created(function ($member) {
            $member->card_number = self::generateCardNo($member->id);
            $member->save();

            $user              = new User;
            $user->last_name   = $member->last_name;
            $user->other_names = $member->other_names;
            $user->email       = $member->email;
            $user->role_id     = 0;
            $user->password    = Hash::make($member->phone_number);
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
