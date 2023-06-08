<?php

namespace App\Http\Controllers;

use App\Models\Outcomming;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OutcommingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('outcomming.list', ['data' => Outcomming::all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Outcomming $outcomming)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Outcomming $outcomming)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Outcomming $outcomming)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Outcomming $outcomming)
    {
        //
    }
}
