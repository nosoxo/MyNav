<?php
namespace App\Traits;


use App\Models\User;

trait BelongsToUser
{
    /**.
     *  add by gui
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * @return mixed
     */
    public function user ()
    {
        return $this->belongsTo (User::class);
    }
}
