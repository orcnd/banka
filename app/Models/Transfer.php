<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Account;
use App\Models\DetailLog;
class Transfer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['source', 'destination', 'amount', 'currency'];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::created(function ($transfer) {
            $transfer->source()->calculateBalance();
            $transfer->destination()->calculateBalance();
            $transfer
                ->source()
                ->user->detailLogs()
                ->create([
                    'event' => 'Transfer Created',
                    'data' => json_encode([
                        'sourceAccount' => $transfer->source()->id,
                        'sourceAccountUser' => $transfer->source()->user->id,
                        'destinationAccount' => $transfer->destination()->id,
                        'destinationAccountUser' => $transfer->destination()
                            ->user->id,
                        'amount' => $transfer->amount,
                        'currency' => $transfer->currency,
                        'id' => $transfer->id,
                    ]),
                    'slug' => 'transferCreated',
                    'description' =>
                        $transfer->amount .
                        '(' .
                        $transfer->currency .
                        ') transferred from ' .
                        $transfer->source()->user->name .
                        '(' .
                        $transfer->source()->name .
                        ') to ' .
                        $transfer->source()->user->name .
                        '(' .
                        $transfer->source()->name .
                        ')',
                ]);
        });
    }

    /**
     * Get the source account
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function source()
    {
        return Account::find($this->source);
    }

    /**
     * Get the source account
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function destination()
    {
        return Account::find($this->destination);
    }
}
