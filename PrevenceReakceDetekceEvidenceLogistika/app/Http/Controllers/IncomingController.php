<?php

namespace App\Http\Controllers;

use App\Http\Requests\IncomingUpdateRequest;
use App\Models\Incoming;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Mockery\Exception;

class IncomingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('incoming.list', ['data' => Incoming::all()]);
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
    public function show(Incoming $incoming): View
    {
        return view('incoming.view', ['value' => $incoming]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Incoming $incoming): View
    {
        return view('incoming.edit', ['value' => $incoming]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(IncomingUpdateRequest $request, Incoming $incoming): RedirectResponse
    {
        $data = $request->validated();
        $data['checked'] = isset($data['checked']);
        $incoming->fill($data);
        $incoming->save();

        return Redirect::route('incoming.view', [$incoming->id])->with('status', 'thingy-updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Incoming $incoming): RedirectResponse
    {
        $incoming->delete();

        return Redirect::route('incoming.list')->with('status', 'thingy-removed');
    }
}
