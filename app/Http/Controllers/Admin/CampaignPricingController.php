<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdsPrice;
use App\Models\Campaign;
use App\Models\Country;
use App\Models\Region;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CampaignPricingController extends Controller
{
    /**
     * Display a listing of the resource.
    */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = AdsPrice::with(['region', 'country'])->orderBy('id', 'asc');

            $pricing = $query->get();
            return DataTables::of($pricing)->toJson();
        }

        return view('admin.pricing.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $countries = Country::get();
        return view('admin.pricing.create', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'country_id' => 'required|exists:countries,id',
            'region_id'  => 'required|exists:regions,id',
            'price'      => 'required|numeric',
        ]);

        $ads_price = new AdsPrice();
        $ads_price->country_id = $request->country_id;
        $ads_price->region_id  = $request->region_id;
        $ads_price->price      = $request->price;
        $ads_price->save();

        return redirect()->route('admin.campaigns-pricing.index')->with('success', __('trans.alert.success.data_created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $countries = Country::get();
        $ads_price = AdsPrice::findOr($id, function () {
            return back()->with('error', __('trans.alert.error.data_not_found'));
        });

        return view('admin.pricing.edit', compact('ads_price', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'country_id' => 'required|exists:countries,id',
            'region_id'  => 'required|exists:regions,id',
            'price'      => 'required|numeric',
        ]);

        $ads_price = AdsPrice::findOr($id, function () {
            return back()->with('error', __('trans.alert.error.data_not_found'));
        });

        $ads_price->country_id = $request->country_id;
        $ads_price->region_id  = $request->region_id;
        $ads_price->price      = $request->price;
        $ads_price->save();

        return redirect()->route('admin.campaigns-pricing.index')->with('success', __('trans.alert.success.data_updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getRegions(Request $request)
    {
        $regions = Region::where([
            'country_id' => $request->country_id,
        ])->select('id', 'name')->get();

        return response()->json(['data' => $regions]);
    }

}
