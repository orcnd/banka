<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAccountRequest;
use App\Http\Requests\UpdateAccountRequest;
use App\Models\Account;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', Account::class);
        if (auth()->user()->role == 'admin') {
            $accounts = Account::all();
        } else {
            $accounts = auth()->user()->accounts;
        }
        return view('crud.index', [
            'title' => 'Accounts',
            'buttons' => [
                'create' => [
                    'text' => 'New Account',
                    'url' => route('account.create'),
                ],
            ],
            'columns' => [
                'name' => ['text' => 'Name', 'type' => 'text'],
                'iban' => ['text' => 'IBAN', 'type' => 'text'],
                'balance' => ['text' => 'Balance', 'type' => 'money'],
                'currency' => ['text' => 'Currency', 'type' => 'text'],
            ],
            'rows' => $accounts,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Account::class);
        return view('crud.create', [
            'route' => route('account.store'),
            'form' => [
                [
                    'name' => 'name',
                    'text' => 'Name',
                    'type' => 'text',
                    'required' => 'required',
                ],
                [
                    'name' => 'currency',
                    'text' => 'Currency',
                    'type' => 'select',
                    'options' => config('app.currencies'),
                    'required' => 'required',
                ],
            ],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAccountRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAccountRequest $request)
    {
        $this->authorize('create', Account::class);
        $account = auth()
            ->user()
            ->accounts()
            ->create($request->all());
        return redirect()->route('account.show', $account);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function show(Account $account)
    {
        $this->authorize('view', $account);
        return view('accountDetail', [
            'data' => $account,
            'title' => 'Account',
            'columns' => [
                'name' => [
                    'text' => 'Name',
                    'type' => 'text',
                ],
                'iban' => [
                    'text' => 'IBAN',
                    'type' => 'text',
                ],
                'balance' => [
                    'text' => 'Balance',
                    'type' => 'money',
                ],
                'currency' => [
                    'text' => 'Currency',
                    'type' => 'text',
                ],
            ],
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function edit(Account $account)
    {
        $this->authorize('update', Account::class);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAccountRequest  $request
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAccountRequest $request, Account $account)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function destroy(Account $account)
    {
        //
    }
}
