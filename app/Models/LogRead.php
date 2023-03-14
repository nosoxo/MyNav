<?php
namespace App\Models;

use App\Traits\DateTimeFormat;
use Illuminate\Database\Eloquent\Model;

class LogRead extends Model
{
    use DateTimeFormat;
    protected $fillable = ['log_id', 'user_id', 'is_read', 'read_at'];

    public function user ()
    {
        return $this->belongsTo (User::class);
    }
}
