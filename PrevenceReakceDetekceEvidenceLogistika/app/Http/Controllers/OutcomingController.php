<?php

namespace App\Http\Controllers;

use App\Http\Requests\OutcomingUpdateRequest;
use App\Models\Outcoming;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class OutcomingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('outcoming.list', ['data' => Outcoming::all()]);
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
    public function show(Outcoming $outcoming): View
    {
        return view('outcoming.view', ['value' => $outcoming]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Outcoming $outcoming)
    {
        return view('outcoming.edit', ['value' => $outcoming]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OutcomingUpdateRequest $request, Outcoming $outcoming): RedirectResponse
    {
        $data = $request->validated();
        $data['checked'] = isset($data['checked']);
        $outcoming->fill($data);
        $outcoming->save();

        return Redirect::route('outcoming.view', [$outcoming->id])->with('status', 'thingy-updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Outcoming $outcoming): RedirectResponse
    {
        $outcoming->delete();

        return Redirect::route('outcoming.list')->with('status', 'thingy-removed');
    }
}
