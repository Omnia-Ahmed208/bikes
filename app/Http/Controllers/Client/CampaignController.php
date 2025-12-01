<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\AdsPrice;
use App\Models\Campaign;
use App\Models\Country;
use App\Models\Region;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Yajra\DataTables\DataTables;


class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
    */
    public function index(Request $request)
    {
        $userId = Auth::user()->id;

        // Get date range from request or use default (current year)
        $startDate = $request->start_date
            ? Carbon::createFromFormat('d-m-Y', $request->start_date)->startOfDay()
            : Carbon::now()->startOfYear();

        $endDate = $request->end_date
            ? Carbon::createFromFormat('d-m-Y', $request->end_date)->endOfDay()
            : Carbon::now()->endOfYear();

        // Get previous period for comparison
        $daysDiff = $startDate->diffInDays($endDate);
        $previousStartDate = $startDate->copy()->subDays($daysDiff + 1);
        $previousEndDate = $startDate->copy()->subDay();

        $all_campaigns = Campaign::where('user_id', $userId)
        ->with(['region', 'country'])
        ->whereBetween('created_at', [$startDate, $endDate])
        ->orderBy('id', 'desc')
        // ->take(2)
        ->get();

        $campaigns_count = Campaign::where('user_id', $userId)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();
        $live_campaigns_count = Campaign::where('user_id', $userId)->where('status', 'live')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();
        $scheduled_campaigns_count = Campaign::where('user_id', $userId)->where('status', 'scheduled')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();
        $finished_campaigns_count = Campaign::where('user_id', $userId)->where('status', 'finished')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        // Previous period counts for comparison
        $previous_campaigns_count = Campaign::where('user_id', $userId)
            ->whereBetween('created_at', [$previousStartDate, $previousEndDate])
            ->count();

        $previous_live_campaigns_count = Campaign::where('user_id', $userId)->where('status', 'live')
            ->whereBetween('created_at', [$previousStartDate, $previousEndDate])
            ->count();

        $previous_scheduled_campaigns_count = Campaign::where('user_id', $userId)->where('status', 'scheduled')
            ->whereBetween('created_at', [$previousStartDate, $previousEndDate])
            ->count();

        $previous_finished_campaigns_count = Campaign::where('user_id', $userId)->where('status', 'finished')
            ->whereBetween('created_at', [$previousStartDate, $previousEndDate])
            ->count();

        $calcChange = fn($current, $previous) => $previous > 0
            ? round((($current - $previous) / $previous) * 100, 2)
            : 100;

        $total_campaigns_percentage = $calcChange($campaigns_count, $previous_campaigns_count);
        $total_campaigns_percentage_abs = abs($total_campaigns_percentage);
        $total_campaigns_status = $total_campaigns_percentage > 0 ? 'success' : 'danger';
        $total_campaigns_chart = $this->getCampaignsChartData($userId, $startDate, $endDate);

        $live_campaigns_percentage = $calcChange($live_campaigns_count, $previous_live_campaigns_count);;
        // $live_campaigns_percentage = $live_campaigns_count == 0 ? 0 : round(($live_campaigns_count - $previous_campaigns_count) / $previous_campaigns_count * 100);
        $live_campaigns_percentage_abs = abs($live_campaigns_percentage);
        $live_campaigns_status = $live_campaigns_percentage > 0 ? 'success' : 'danger';
        $live_campaigns_chart = $this->getCampaignsChartData($userId, $startDate, $endDate);

        $scheduled_campaigns_percentage = $calcChange($scheduled_campaigns_count, $previous_scheduled_campaigns_count);
        $scheduled_campaigns_percentage_abs = abs($scheduled_campaigns_percentage);
        $scheduled_campaigns_status = $scheduled_campaigns_percentage > 0 ? 'success' : 'danger';
        $scheduled_campaigns_chart = $this->getCampaignsChartData($userId, $startDate, $endDate);

        $finished_campaigns_percentage = $calcChange($finished_campaigns_count, $previous_finished_campaigns_count);
        $finished_campaigns_percentage_abs = abs($finished_campaigns_percentage);
        $finished_campaigns_status = $finished_campaigns_percentage > 0 ? 'success' : 'danger';
        $finished_campaigns_chart = $this->getCampaignsChartData($userId, $startDate, $endDate);


        // =========== Ads countries
        // // أسماء الدول
        $country_labels = $all_campaigns->map(function ($campaign) {
            return $campaign->country ? $campaign->country->name : 'Unknown';
        })->unique()->values()->toArray();

        // عدد الحملات في كل دولة
        $country_campaigns_count = $all_campaigns->groupBy(function ($campaign) {
            return $campaign->country ? $campaign->country->name : 'Unknown';
        })->map->count()->values()->toArray();

        $campaigns = $all_campaigns->take(2);

        return view('client.campaign.index', compact([
            'campaigns',
            'campaigns_count',
            'live_campaigns_count',
            'scheduled_campaigns_count',
            'finished_campaigns_count',

            'total_campaigns_percentage',
            'total_campaigns_percentage_abs',
            'total_campaigns_status',
            'total_campaigns_chart',

            'live_campaigns_percentage',
            'live_campaigns_percentage_abs',
            'live_campaigns_status',
            'live_campaigns_chart',

            'scheduled_campaigns_percentage',
            'scheduled_campaigns_percentage_abs',
            'scheduled_campaigns_status',
            'scheduled_campaigns_chart',

            'finished_campaigns_percentage',
            'finished_campaigns_percentage_abs',
            'finished_campaigns_status',
            'finished_campaigns_chart',

            'country_labels',
            'country_campaigns_count',
        ]));
    }

    public function index3(Request $request)
    {
        $userId = Auth::user()->id;

        // Get date range from request or use default (current year)
        $startDate = $request->start_date
            ? Carbon::createFromFormat('d-m-Y', $request->start_date)->startOfDay()
            : Carbon::now()->startOfYear();

        $endDate = $request->end_date
            ? Carbon::createFromFormat('d-m-Y', $request->end_date)->endOfDay()
            : Carbon::now()->endOfYear();

        // Get previous period for comparison
        $daysDiff = $startDate->diffInDays($endDate);
        $previousStartDate = $startDate->copy()->subDays($daysDiff + 1);
        $previousEndDate = $startDate->copy()->subDay();

        // Current period campaigns
        $campaigns = Campaign::where('user_id', $userId)
            ->with(['region'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('id', 'desc')
            ->take(2)
            ->get();

        // Current period counts
        $campaigns_count = Campaign::where('user_id', $userId)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        $live_campaigns_count = Campaign::where('user_id', $userId)
            ->where('status', 'live')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        $scheduled_campaigns_count = Campaign::where('user_id', $userId)
            ->where('status', 'scheduled')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        $finished_campaigns_count = Campaign::where('user_id', $userId)
            ->where('status', 'finished')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        // Previous period counts for comparison
        $previous_campaigns_count = Campaign::where('user_id', $userId)
            ->whereBetween('created_at', [$previousStartDate, $previousEndDate])
            ->count();

        // Calculate percentage change
        $total_campaigns_percentage = 0;
        $total_campaigns_percentage_abs = 0;
        $total_campaigns_status = 'secondary';

        if ($previous_campaigns_count > 0) {
            $total_campaigns_percentage = (($campaigns_count - $previous_campaigns_count) / $previous_campaigns_count) * 100;
            $total_campaigns_percentage_abs = abs(round($total_campaigns_percentage, 2));
            $total_campaigns_status = $total_campaigns_percentage >= 0 ? 'success' : 'danger';
        }

        // Prepare chart data (last 12 months or custom period)
        $total_campaigns_chart = $this->getCampaignsChartData($userId, $startDate, $endDate);

        return view('client.campaign.index', compact([
            'campaigns',
            'campaigns_count',
            'live_campaigns_count',
            'scheduled_campaigns_count',
            'finished_campaigns_count',

            'total_campaigns_percentage',
            'total_campaigns_percentage_abs',
            'total_campaigns_status',
            'total_campaigns_chart',
        ]));
    }

    private function getCampaignsChartData($userId, $startDate, $endDate)
    {
        $daysDiff = $startDate->diffInDays($endDate);

        // If period is less than 60 days, show daily data
        if ($daysDiff <= 60) {
            $data = [];
            $currentDate = $startDate->copy();

            while ($currentDate <= $endDate) {
                $count = Campaign::where('user_id', $userId)
                    ->whereDate('created_at', $currentDate)
                    ->count();

                $data[] = $count;
                $currentDate->addDay();
            }

            return $data;
        }

        // If period is less than 2 years, show monthly data
        if ($daysDiff <= 730) {
            $data = [];
            $currentDate = $startDate->copy()->startOfMonth();
            $endMonth = $endDate->copy()->endOfMonth();

            while ($currentDate <= $endMonth) {
                $count = Campaign::where('user_id', $userId)
                    ->whereYear('created_at', $currentDate->year)
                    ->whereMonth('created_at', $currentDate->month)
                    ->count();

                $data[] = $count;
                $currentDate->addMonth();
            }

            return $data;
        }

        // For longer periods, show yearly data
        $data = [];
        $currentYear = $startDate->year;
        $endYear = $endDate->year;

        while ($currentYear <= $endYear) {
            $count = Campaign::where('user_id', $userId)
                ->whereYear('created_at', $currentYear)
                ->count();

            $data[] = $count;
            $currentYear++;
        }

        return $data;
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
            'title'             => 'required|string',
            'country_id'        => 'required|exists:countries,id',
            'region_id'         => 'required|exists:regions,id',
            'bikes_count'       => 'required|integer',
            'media'             => 'required|file|mimes:jpeg,png,jpg,mp4|max:2048',
            'media_duration'    => 'required|integer',
            'campaign_duration' => 'required|string',
            'date_time'         => 'required|string',
        ]);

        $campaign = new Campaign();

        // list($start, $end) = explode(' to ', $request->date_time);
        $dateStr = str_replace('—', 'to', $request->date_time); // استبدل الـ dash بـ 'to'
        $dateParts = explode('to', $dateStr);

        if (strpos($dateStr, __('trans.global.to')) !== false) {
            $dateStr = str_replace(__('trans.global.to'), 'to', $request->date_time);
            $dateParts = explode('to', $dateStr);
        }

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

        $ads_price = AdsPrice::where('country_id', $request->country_id)
        ->where('region_id', $request->region_id)->first();

        $campaign->user_id           = Auth::user()->id;
        $campaign->title             = $request->title;
        $campaign->country_id        = $request->country_id;
        $campaign->region_id         = $request->region_id;
        $campaign->bikes_count       = $request->bikes_count;
        $campaign->media_duration    = $request->media_duration;
        $campaign->campaign_duration = $request->campaign_duration;
        $campaign->price             = $ads_price ?? 0;
        $campaign->save();

        // return redirect()->route('client.campaigns.live')->with('success',  __('trans.alert.success.done_create'));
        return back()->with('payment_success',  __('trans.alert.success.done_create'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $campaign = Campaign::with(['country', 'region'])->findOr($id, function () {
            return back()->with('error', __('trans.alert.error.data_not_found'));
        });

        return view('client.campaign.show', compact('campaign'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $campaign = Campaign::findOr($id, function () {
            return back()->with('error', __('trans.alert.error.data_not_found'));
        });

        $countries = Country::get();

        return view('client.campaign.edit', compact('campaign', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title'             => 'required|string',
            'country_id'        => 'required|exists:countries,id',
            'region_id'         => 'required|exists:regions,id',
            'bikes_count'       => 'required|integer',
            'media'             => 'nullable|file|mimes:jpeg,png,jpg,mp4|max:2048',
            'media_duration'    => 'required|integer',
            'campaign_duration' => 'required|string',
            'date_time'         => 'required|string',
        ]);

        $campaign = Campaign::findOrFail($id);

        // list($start, $end) = explode(' to ', $request->date_time);
        $dateStr = str_replace('—', 'to', $request->date_time); // استبدل الـ dash بـ 'to'
        $dateParts = explode('to', $dateStr);

        if (strpos($dateStr, __('trans.global.to')) !== false) {
            $dateStr = str_replace(__('trans.global.to'), 'to', $request->date_time);
            $dateParts = explode('to', $dateStr);
        }

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
            if($campaign->file){
                unlink(public_path($campaign->file));
            }

            $media = $request->file('media');
            $media_name = time() . '.' . $media->getClientOriginalExtension();
            $media->move(public_path('uploads/user_' . Auth::user()->id . '/campaigns/'), $media_name);
            $campaign->file = 'uploads/user_' . Auth::user()->id . '/campaigns/' . $media_name;

            $campaign->file_type = $request->file('media')->getClientOriginalExtension() == 'mp4' ? 'video' : 'image';
        }

        $ads_price = AdsPrice::where('country_id', $request->country_id)
        ->where('region_id', $request->region_id)->first();

        $campaign->title             = $request->title;
        $campaign->country_id        = $request->country_id;
        $campaign->region_id         = $request->region_id;
        $campaign->bikes_count       = $request->bikes_count;
        $campaign->media_duration    = $request->media_duration;
        $campaign->campaign_duration = $request->campaign_duration;
        $campaign->price             = $ads_price ?? 0;
        $campaign->save();

        // return redirect()->route('client.campaigns.live')->with('success',  __('trans.alert.success.done_create'));
        return back()->with('payment_success',  __('trans.alert.success.done_create'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function campaigns_live(request $request)
    {
        if ($request->ajax()) {
            $query = Campaign::where('user_id', Auth::user()->id)->with(['region']);

            if($request->status != 'all'){
                $query->where('status', $request->status);
            }

            if ($request->filled('status_filter') && $request->status_filter != 'all') {
                $query->where('status', $request->status_filter);
            }

            if ($request->filled('sort_filter') && $request->sort_filter != 'all') {
                switch ($request->sort_filter) {
                    case 'name':
                        $query->orderBy('title', 'asc');
                        break;
                    case 'latest':
                        $query->orderBy('created_at', 'desc');
                        break;
                    case 'oldest':
                        $query->orderBy('created_at', 'asc');
                        break;
                    default:
                        $query->orderBy('id', 'asc');
                }
            } else {
                $query->orderBy('id', 'asc');
            }

            $campaigns = $query->get();

            return DataTables::of($campaigns)->toJson();
        }

        return view('client.campaign.live');
    }

    public function campaigns_live_export(request $request)
    {
        $query = Campaign::where('user_id', Auth::user()->id)->with(['region']);

        if($request->status != 'all'){
            $query->where('status', $request->status);
        }

         if ($request->filled('status_filter') && $request->status_filter != 'all') {
            $query->where('status', $request->status_filter);
        }

        if ($request->filled('sort_filter')) {
            switch ($request->sort_filter) {
                case 'name':
                    $query->orderBy('title', 'asc');
                    break;
                case 'latest':
                    $query->orderBy('created_at', 'desc');
                    break;
                case 'oldest':
                    $query->orderBy('created_at', 'asc');
                    break;
                default:
                    $query->orderBy('id', 'desc');
            }
        } else {
            $query->orderBy('id', 'desc');
        }

        $campaigns = $query->get();

        // Create a new Spreadsheet object
        $spreadsheet = new Spreadsheet();

        // Get the active sheet
        $sheet = $spreadsheet->getActiveSheet();
        $columns = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];
        foreach ($columns as $columnKey => $column):
            $Width = ($columnKey==1||$columnKey==2)? 25 : 15;
            $sheet->getColumnDimension($column)->setWidth($Width);
            $sheet->getStyle($column.'1')->applyFromArray([
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'color' => ['rgb' => 'FFFF00'], // Yellow background
                ],
            ]);
        endforeach;
        $sheet->setRightToLeft(true);

        // Set cell values
        $sheet->setCellValue('A1', __('trans.campaign.name'));
        $sheet->setCellValue('B1', __('trans.campaign.media'));
        $sheet->setCellValue('C1', __('trans.campaign.region'));
        $sheet->setCellValue('D1', __('trans.campaign.bikes_count'));
        $sheet->setCellValue('E1', __('trans.campaign.campaign_duration'));
        $sheet->setCellValue('F1', __('trans.campaign.price'));
        $sheet->setCellValue('G1', __('trans.campaign.status'));
        $sheet->setCellValue('H1', __('trans.campaign.date'));

        foreach ($campaigns as $key => $item):
            $key = $key+2;

            if($item->status == 'live'){
                $status = __('trans.campaign.live');
            }elseif($item->status == 'finished'){
                $status = __('trans.campaign.finished');
            } elseif($item->status == 'stopped'){
                $status = __('trans.campaign.stopped');
            } elseif($item->status == 'scheduled'){
                $status = __('trans.campaign.scheduled');
            }

            if($item->campaign_duration == '12_hour'){
                $campaign_duration = __('trans.campaign.12_hour');
            }elseif($item->campaign_duration == '1_day'){
                $campaign_duration = __('trans.campaign.1_day');
            } elseif($item->campaign_duration == '3_days'){
                $campaign_duration = __('trans.campaign.3_days');
            }

            // اللينك لو موجود
            if ($item->file) {
                $url = asset($item->file);
                if($item->file_type == 'image'){
                    $sheet->setCellValue('B'.$key, __('trans.campaign.image'));
                } else if($item->file_type == 'vedio'){
                    $sheet->setCellValue('B'.$key, __('trans.campaign.video'));
                }
                $sheet->getCell('B'.$key)->getHyperlink()
                    ->setUrl($url)
                    ->setTooltip(__('trans.campaign.media'));
            } else {
                $sheet->setCellValue('C'.$key, '-');
            }

            $sheet->setCellValue('A'.$key, $item->title ?? '-');
            $sheet->setCellValue('C'.$key, $item->region->name ?? '-');
            $sheet->setCellValue('D'.$key, $item->bikes_count);
            $sheet->setCellValue('E'.$key, $campaign_duration);
            $sheet->setCellValue('F'.$key, $item->price);
            $sheet->setCellValue('G'.$key, $status ?? '-');
            $sheet->setCellValue('H'.$key, $item->created_at ?? '-');
            // $sheet->setCellValueExplicit('B'.$key, $item->phone ?? '-', DataType::TYPE_STRING);
        endforeach;

        $writer = new Xlsx($spreadsheet);
        $today = date('Y-m-d');
        $fileName = __('trans.campaign.title')."- $today".".xlsx";
        $writer->save($fileName);
        return response()->download(public_path($fileName))->deleteFileAfterSend(true);
    }

    public function getRegions(Request $request)
    {
        $regions = Region::where([
            'country_id' => $request->country_id,
        ])->select('id', 'name')->get();

        return response()->json(['data' => $regions]);
    }

}
