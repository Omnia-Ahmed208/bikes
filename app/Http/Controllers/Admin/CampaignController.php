<?php

namespace App\Http\Controllers\Admin;

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
        if ($request->ajax()) {
            $query = Campaign::with(['region', 'user']);

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

        return view('admin.campaign.index');
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

    public function campaigns_review(Request $request)
    {
        $new_campaigns_count = Campaign::with(['region', 'user'])->where('approval_status', 'pending')->count();
        $approved_campaigns_count = Campaign::with(['region', 'user'])->where('approval_status', 'accepted')->count();
        $not_approved_campaigns_count = Campaign::with(['region', 'user'])->where('approval_status', 'rejected')->count();

        if ($request->ajax()) {
            $query = Campaign::with(['region', 'user']);

            if($request->status != 'all'){
                $query->where('approval_status', $request->status);
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

        return view('admin.campaign.review', compact('new_campaigns_count', 'approved_campaigns_count', 'not_approved_campaigns_count'));
    }

    public function campaigns_export(request $request)
    {
        $query = Campaign::with(['region', 'user']);

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
        $sheet->setCellValue('C1', __('trans.campaign.user_name'));
        $sheet->setCellValue('D1', __('trans.campaign.region'));
        $sheet->setCellValue('E1', __('trans.campaign.bikes_count'));
        $sheet->setCellValue('F1', __('trans.campaign.campaign_duration'));
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
            $sheet->setCellValue('C'.$key, $item->user->name ?? '-');
            $sheet->setCellValue('D'.$key, $item->region->name ?? '-');
            $sheet->setCellValue('E'.$key, $item->bikes_count);
            $sheet->setCellValue('F'.$key, $campaign_duration);
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
