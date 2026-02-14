<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberSavings extends Model
{
    use HasFactory;

    public function agent()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function member()
    {
        return $this->belongsTo('App\Models\Members', 'member_id');
    }
}
