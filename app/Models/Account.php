<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    /**
     * The attributes account can have
     *
     * @var array<int, string, decimal, int>
     */

    protected $fillable = [
        'name',
        'slug',
        'balance',
        'user_id',
        'currency',
        'iban',
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::created(function ($account) {
            //creating iban
            $account->iban =
                config('app.bankIbanHeader') .
                str_pad($account->id, 16, '0', STR_PAD_LEFT);
            $account->save();

            $account->user->detailLogs()->create([
                'event' => 'Account Created',
                'data' => json_encode([
                    'user' => $account->user->id,
                    'iban' => $account->iban,
                    'currency' => $account->currency,
                    'id' => $account->id,
                ]),
                'slug' => 'accountCreated',
                'description' =>
                    'Account Created by' .
                    $account->user->name .
                    '(' .
                    $account->name .
                    ') in ' .
                    $account->currency .
                    '(' .
                    $account->iban .
                    ')',
            ]);
        });
    }

    public function calculateBalance()
    {
        $balance = -\App\Models\Transfer::where('source', $this->id)->sum(
            'amount'
        );
        $balance += \App\Models\Transfer::where('destination', $this->id)->sum(
            'amount'
        );
        $this->balance = $balance;
        $this->transfers()->sum('amount');
        $this->save();
    }

    /**
     * User this account belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the transfers for the account.
     *
     * @return collection
     */
    public function transfers()
    {
        return \App\Models\Transfer::where('source', $this->id)
            ->orWhere('destination', $this->id)
            ->get();
    }
}
