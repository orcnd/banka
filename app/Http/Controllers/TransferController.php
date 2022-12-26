<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransferRequest;
use App\Http\Requests\UpdateTransferRequest;
use App\Models\Transfer;
use App\Models\Account;
use Illuminate\Http\Request;

class TransferController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createBetween()
    {
        $this->authorize('create', Transfer::class);

        $userAccounts = [];
        if (auth()->user()->role == 'admin') {
            foreach (Account::all() as $d) {
                $userAccounts[
                    $d->id
                ] = "{$d->user->name} {$d->name} {$d->amount} {$d->currency} ({$d->id}) {$d->iban}";
            }
        } else {
            foreach (auth()->user()->accounts as $d) {
                $userAccounts[
                    (string) $d->id
                ] = "{$d->name} ({$d->amount} {$d->currency})";
            }
        }
        return view('crud.create', [
            'route' => route('transfer.storeBetween'),
            'form' => [
                [
                    'name' => 'source',
                    'text' => 'Source',
                    'type' => 'select',
                    'options' => $userAccounts,
                    'required' => 'required',
                ],
                [
                    'name' => 'destination',
                    'text' => 'Destination',
                    'type' => 'select',
                    'options' => $userAccounts,
                    'required' => 'required',
                ],
                [
                    'name' => 'amount',
                    'text' => 'Amount',
                    'type' => 'money',
                    'required' => 'required',
                ],
            ],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createEft()
    {
        $this->authorize('create', Transfer::class);

        $userAccounts = [];
        if (auth()->user()->role == 'admin') {
            foreach (Account::all() as $d) {
                $userAccounts[
                    $d->id
                ] = "{$d->user->name} {$d->name} {$d->amount} {$d->currency} ({$d->id}) {$d->iban}";
            }
        } else {
            foreach (auth()->user()->accounts as $d) {
                $userAccounts[
                    (string) $d->id
                ] = "{$d->name} ({$d->amount} {$d->currency})";
            }
        }

        return view('crud.create', [
            'route' => route('transfer.storeEft'),
            'form' => [
                [
                    'name' => 'source',
                    'text' => 'Source',
                    'type' => 'select',
                    'options' => $userAccounts,
                    'required' => 'required',
                ],
                [
                    'name' => 'destination',
                    'text' => 'Destination IBAN',
                    'type' => 'text',
                    'required' => 'required',
                ],
                [
                    'name' => 'amount',
                    'text' => 'Amount',
                    'type' => 'money',
                    'required' => 'required',
                ],
            ],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createCash()
    {
        $this->authorize('create', Transfer::class);
        $userAccounts = [];
        if (auth()->user()->role == 'admin') {
            foreach (Account::all() as $d) {
                $userAccounts[
                    $d->id
                ] = "{$d->user->name} {$d->name} {$d->amount} {$d->currency} ({$d->id}) {$d->iban}";
            }
        } else {
            foreach (auth()->user()->accounts as $d) {
                $userAccounts[
                    (string) $d->id
                ] = "{$d->name} ({$d->amount} {$d->currency})";
            }
        }

        return view('crud.create', [
            'route' => route('transfer.storeCash'),
            'form' => [
                [
                    'name' => 'destination',
                    'text' => 'Destination',
                    'type' => 'select',
                    'options' => $userAccounts,
                    'required' => 'required',
                ],
                [
                    'name' => 'amount',
                    'text' => 'Amount',
                    'type' => 'money',
                    'required' => 'required',
                ],
            ],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTransferRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function storeBetween(Request $request)
    {
        $request->validate([
            'source' => 'string|required',
            'destination' => 'string|required',
            'amount' => 'numeric|required',
        ]);
        $data = $request->all();
        $source = Account::select('*')->findOrFail($data['source']);
        $destination = Account::select('*')->findOrFail($data['destination']);

        //check for source and destination ownership or admin role
        if (
            auth()->user()->role != 'admin' &&
            (auth()->user()->id != $source->user_id ||
                auth()->user()->id != $destination->user_id)
        ) {
            return abort(403);
        }

        //check currency match between source and destination
        if ($source->currency != $destination->currency) {
            return abort(403);
        }

        $a = Transfer::create([
            'source' => $source->id,
            'destination' => $destination->id,
            'amount' => $data['amount'],
            'currency' => $destination->currency,
        ]);

        return redirect(route('account.index', $destination->id));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTransferRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function storeEft(Request $request)
    {
        $request->validate([
            'source' => 'string|required',
            'destination' => 'string|required',
            'amount' => 'numeric|required',
        ]);
        $data = $request->all();
        $source = Account::select('*')->findOrFail($data['source']);
        $destination = Account::select('*')
            ->where('iban', $data['destination'])
            ->firstOrFail();

        //check for source and destination ownership or admin role
        if (
            auth()->user()->role != 'admin' &&
            auth()->user()->id != $source->user_id
        ) {
            return abort(403);
        }

        //check currency match between source and destination
        if ($source->currency != $destination->currency) {
            return abort(403);
        }

        $a = Transfer::create([
            'source' => $source->id,
            'destination' => $destination->id,
            'amount' => $data['amount'],
            'currency' => $destination->currency,
        ]);

        return redirect(route('account.show', $destination->id));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeCash(Request $request)
    {
        $request->validate([
            'destination' => 'string|required',
            'amount' => 'numeric|required',
        ]);
        $data = $request->all();
        $destination = Account::select('*')->findOrFail($data['destination']);

        $source = Account::select('*')
            ->where('slug', 'kasaNakit' . $destination->currency)
            ->firstOrFail();

        //check for source and destination ownership or admin role
        if (
            auth()->user()->role != 'admin' &&
            auth()->user()->id != $destination->user_id
        ) {
            return abort(403);
        }

        //check currency match between source and destination
        if ($source->currency != $destination->currency) {
            return abort(403);
        }

        $a = Transfer::create([
            'source' => $source->id,
            'destination' => $destination->id,
            'amount' => $data['amount'],
            'currency' => $destination->currency,
        ]);

        return redirect(route('account.show', $destination->id));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transfer  $transfer
     * @return \Illuminate\Http\Response
     */
    public function show(Transfer $transfer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transfer  $transfer
     * @return \Illuminate\Http\Response
     */
    public function edit(Transfer $transfer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTransferRequest  $request
     * @param  \App\Models\Transfer  $transfer
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTransferRequest $request, Transfer $transfer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transfer  $transfer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transfer $transfer)
    {
        //
    }
}
