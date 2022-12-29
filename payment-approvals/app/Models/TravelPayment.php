<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TravelPayment extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'amount',
    ];

    protected $appends = ['is_approved'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getIsApprovedAttribute(): bool
    {
        $statuses = PaymentApproval::where('payment_type', 'TRAVEL')
            ->where('payment_id', $this->id)
            ->get()
            ->pluck('status')
            ->toArray();

        if (count($statuses) > 0 && !in_array('DISAPPROVED', $statuses)) {
            return true;
        }
        return false;
    }
}
