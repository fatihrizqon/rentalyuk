<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Cashflow;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Exports\CashflowsExport;
use App\Services\CashflowService;
use Illuminate\Support\Facades\Auth;

class CashflowController extends Controller
{
    private $service;
    private $date;
    private $from;
    private $to;
    private $duration;

    public function __construct(CashflowService $service, Request $request)
    {
        $this->service  = $service;
        $this->date     = Carbon::now()->minute(0)->second(0)->format('Y-m-d\TH:i');
        $this->from     = Carbon::parse($request->from)->minute(0)->second(0)->format('Y-m-d\TH:i');
        $this->to       = Carbon::parse($request->to)->minute(0)->second(0)->format('Y-m-d\TH:i');
        $this->duration = Carbon::parse($this->from)->diffInDays(Carbon::parse($this->to), false);
    }

    public function index(Request $request)
    {
        try {
            $cashflows = $this->service->index($request->all());
            return view('admin.cashflow.index', [
                'cashflows'=> $cashflows,
                'date'     => $this->date,
                'from'     => $this->from,
                'to'       => $this->to,
                'keywords' => $request->keywords
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'name'  => ['required', 'min:3'],
            'type'  => ['required'],
            'value' => ['required', 'min:3']
        ]);
         
        try {
            $this->service->create($attributes);
            return redirect()->back()->with('status', 'a new transaction has been created.');
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function export(Request $request)
    {
        $filename = 'Cashflow Data Export '.Carbon::now()->format('Y-m-d H:i:s').'.xlsx';
        $filters  = [
            'from'     => $request->from,
            'to'       => $request->to,
            'keywords' => $request->keywords,
        ];
        return (new CashflowsExport($filters))->download($filename);
    }
}
