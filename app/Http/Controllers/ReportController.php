<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use App\Models\EvaluationPeriod;
use App\Models\Skt;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index()
    {
        $availableYears = EvaluationPeriod::select('tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');
            
        $staff = User::where('peranan', 'pyd')
            ->orderBy('name')
            ->get();
            
        return view('reports.index', compact('availableYears', 'staff'));
    }

    public function generateSktReport(Request $request)
    {
        $year = $request->input('year', date('Y'));
        
        $skts = Skt::with(['pyd', 'ppp', 'evaluationPeriod'])
            ->whereHas('evaluationPeriod', function($q) use ($year) {
                $q->where('tahun', $year);
            })
            ->orderBy('status')
            ->get();
            
        $pdf = Pdf::loadView('reports.skt', compact('skts', 'year'));
        return $pdf->download('laporan-skt-' . $year . '.pdf');
    }

    public function generateEvaluationReport(Request $request)
    {
        $year = $request->input('year', date('Y'));
        
        $evaluations = Evaluation::with(['pyd', 'ppp', 'ppk', 'scores.criteria', 'evaluationPeriod'])
            ->whereHas('evaluationPeriod', function($q) use ($year) {
                $q->where('tahun', $year);
            })
            ->orderBy('status')
            ->get();
            
        $pdf = Pdf::loadView('reports.evaluation', compact('evaluations', 'year'));
        return $pdf->download('laporan-penilaian-' . $year . '.pdf');
    }

    public function generateIndividualReport(Request $request)
    {
        $staff = User::findOrFail($request->input('staff_id'));
        $year = $request->input('year', date('Y'));
        
        $skt = Skt::with(['evaluationPeriod'])
            ->where('pyd_id', $staff->id)
            ->whereHas('evaluationPeriod', function($q) use ($year) {
                $q->where('tahun', $year);
            })
            ->first();
            
        $evaluation = Evaluation::with(['scores.criteria', 'ppp', 'ppk', 'evaluationPeriod'])
            ->where('pyd_id', $staff->id)
            ->whereHas('evaluationPeriod', function($q) use ($year) {
                $q->where('tahun', $year);
            })
            ->first();
            
        $pdf = Pdf::loadView('reports.individual', compact('staff', 'year', 'skt', 'evaluation'));
        return $pdf->download('laporan-individu-' . $staff->name . '-' . $year . '.pdf');
    }
}