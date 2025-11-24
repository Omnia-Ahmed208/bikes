<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Country;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('client.campaign.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $countries = Country::get();
        return view('client.campaign.create', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'country_id' => 'required|exists:countries,id',
            'region_id' => 'required|exists:regions,id',
            'bikes_count' => 'required|integer',
            'media' => 'required|file|mimes:jpeg,png,jpg,mp4|max:2048',
            'media_duration' => 'required|integer',
            'campaign_duration' => 'required|string',
            'date_time' => 'required|string',
        ]);

        $campaign = new Campaign();

        // list($start, $end) = explode(' to ', $request->date_time);
        $dateStr = str_replace('—', 'to', $request->date_time); // استبدل الـ dash بـ 'to'
        $dateParts = explode('to', $dateStr);

        if(count($dateParts) < 2){
            return back()->withErrors(['date_time' => 'Please select a valid start and end date.'])->withInput();
        }

        $start = trim($dateParts[0]);
        $end = trim($dateParts[1]);

        $campaign->start_date = date('Y-m-d', strtotime($start));
        $campaign->start_time = date('H:i', strtotime($start));
        $campaign->end_date = date('Y-m-d', strtotime($end));
        $campaign->end_time = date('H:i', strtotime($end));

        if($request->hasFile('media')) {
            $media = $request->file('media');
            $media_name = time() . '.' . $media->getClientOriginalExtension();
            $media->move(public_path('uploads/user_' . Auth::user()->id . '/campaigns/'), $media_name);
            $campaign->file = 'uploads/user_' . Auth::user()->id . '/campaigns/' . $media_name;

            $campaign->file_type = $request->file('media')->getClientOriginalExtension() == 'mp4' ? 'video' : 'image';
        }

        $campaign->user_id = Auth::user()->id;
        $campaign->title = $request->title;
        $campaign->country_id = $request->country_id;
        $campaign->region_id = $request->region_id;
        $campaign->bikes_count = $request->bikes_count;
        $campaign->media_duration = $request->media_duration;
        $campaign->campaign_duration = $request->campaign_duration;
        $campaign->price = 0;
        $campaign->save();

        // return redirect()->route('client.campaigns.index')->with('success',  __('trans.alert.success.done_create'));
        return back()->with('payment_success',  __('trans.alert.success.done_create'));

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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
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
            'country_id'       => $request->country_id,
        ])->select('id', 'name')->get();

        return response()->json(['data' => $regions]);
    }

}
