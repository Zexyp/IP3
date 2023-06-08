<?php

namespace App\Http\Controllers;

use App\Models\Incomming;
use Illuminate\Http\Request;
use Illuminate\View\View;

class IncommingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('incomming.list', ['data' => Incomming::all()]);
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
    public function show(Incomming $incomming)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Incomming $incomming)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Incomming $incomming)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Incomming $incomming)
    {
        //
    }
}
