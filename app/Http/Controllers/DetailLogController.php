<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDetailLogRequest;
use App\Http\Requests\UpdateDetailLogRequest;
use App\Models\DetailLog;

class DetailLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreDetailLogRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDetailLogRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DetailLog  $detailLog
     * @return \Illuminate\Http\Response
     */
    public function show(DetailLog $detailLog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DetailLog  $detailLog
     * @return \Illuminate\Http\Response
     */
    public function edit(DetailLog $detailLog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDetailLogRequest  $request
     * @param  \App\Models\DetailLog  $detailLog
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDetailLogRequest $request, DetailLog $detailLog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DetailLog  $detailLog
     * @return \Illuminate\Http\Response
     */
    public function destroy(DetailLog $detailLog)
    {
        //
    }
}
