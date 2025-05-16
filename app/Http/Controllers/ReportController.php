<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use App\Models\EvaluationPeriod;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index()
    {
        $periods = EvaluationPeriod::all();
        return view('reports.index', compact('periods'));
    }

    public function generateEvaluationReport($periodId)
    {
        $period = EvaluationPeriod::findOrFail($periodId);
        $evaluations = Evaluation::where('evaluation_period_id', $periodId)
            ->where('status', 'selesai')
            ->get();
            
        $pdf = Pdf::loadView('reports.evaluation', compact('period', 'evaluations'));
        return $pdf->download('laporan-penilaian-' . $period->tahun . '.pdf');
    }

    public function generateSktReport($periodId)
    {
        $period = EvaluationPeriod::findOrFail($periodId);
        $skts = Skt::where('evaluation_period_id', $periodId)
            ->where('status', 'disahkan')
            ->get();
            
        $pdf = Pdf::loadView('reports.skt', compact('period', 'skts'));
        return $pdf->download('laporan-skt-' . $period->tahun . '.pdf');
    }

    public function generateIndividualReport($evaluationId)
    {
        $evaluation = Evaluation::findOrFail($evaluationId);
        $totalScores = $evaluation->calculateTotalScore();
        
        $pdf = Pdf::loadView('reports.individual', compact('evaluation', 'totalScores'));
        return $pdf->download('laporan-individu-' . $evaluation->pyd->name . '-' . $evaluation->evaluationPeriod->tahun . '.pdf');
    }
}