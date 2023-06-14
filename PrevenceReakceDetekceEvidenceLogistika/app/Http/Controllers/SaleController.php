<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaleStoreRequest;
use App\Http\Requests\SaleUpdateRequest;
use App\Models\Sale;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('sale.list', ['data' => Sale::all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('sale.new');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SaleStoreRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['checked'] = isset($data['checked']);

        $sale = new Sale();
        $sale->fill($data);
        $sale->save();

        return Redirect::route('sale.view', [$sale->id])->with('status', 'thingy-created');
    }

    public function storeByEmployee(SaleStoreRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $sale = new Sale();
        $sale->fill($data);
        $sale->save();

        return Redirect::route('sale.view', [$sale->id])->with('status', 'thingy-created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Sale $sale): View
    {
        return view('sale.view', ['value' => $sale]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sale $sale): View
    {
        return view('sale.edit', ['value' => $sale]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SaleUpdateRequest $request, Sale $sale): RedirectResponse
    {
        $data = $request->validated();
        $sale->fill($data);
        $sale->save();

        return Redirect::route('sale.view', [$sale->id])->with('status', 'thingy-updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sale $sale): RedirectResponse
    {
        $sale->delete();

        return Redirect::route('sale.list')->with('status', 'thingy-removed');
    }
}
