<?php

namespace App\Http\Controllers;

use App\Models\EvaluationPeriod;
use Illuminate\Http\Request;
use Spatie\Activitylog\Facades\Activity;
use Carbon\Carbon;

class EvaluationPeriodController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->input('year', date('Y'));
        $jenis = $request->input('jenis');
        
        $periods = EvaluationPeriod::year($year)
            ->when($jenis, function($query) use ($jenis) {
                return $query->where('jenis', $jenis);
            })
            ->orderBy('tahun', 'desc')
            ->paginate(10);
            
        $availableYears = EvaluationPeriod::select('tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');
            
        return view('admin.evaluation_periods.index', compact('periods', 'availableYears', 'year', 'jenis'));
    }

    public function create()
    {
        $currentYear = date('Y');
        return view('admin.evaluation_periods.create', compact('currentYear'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis' => 'required|in:skt,penilaian',
            'tahun' => 'required|digits:4|integer|min:'.date('Y'),
        ]);
        
        $data = ['tahun' => $request->tahun, 'jenis' => $request->jenis];
        
        if ($request->jenis === 'skt') {
            $request->validate([
                'tarikh_mula_awal' => 'required|date',
                'tarikh_tamat_awal' => 'required|date|after_or_equal:tarikh_mula_awal',

                'tarikh_mula_pertengahan' => 'required|date|after_or_equal:tarikh_tamat_awal',
                'tarikh_tamat_pertengahan' => 'required|date|after_or_equal:tarikh_mula_pertengahan',

                'tarikh_mula_akhir' => 'required|date|after_or_equal:tarikh_tamat_pertengahan',
                'tarikh_tamat_akhir' => 'required|date|after_or_equal:tarikh_mula_akhir',
            ]);
            
            $data = array_merge($data, [
                'tarikh_mula_awal' => $request->tarikh_mula_awal,
                'tarikh_tamat_awal' => $request->tarikh_tamat_awal,
                'tarikh_mula_pertengahan' => $request->tarikh_mula_pertengahan,
                'tarikh_tamat_pertengahan' => $request->tarikh_tamat_pertengahan,
                'tarikh_mula_akhir' => $request->tarikh_mula_akhir,
                'tarikh_tamat_akhir' => $request->tarikh_tamat_akhir,
            ]);
        } else {
            $request->validate([
                'tarikh_mula_penilaian' => 'required|date',
                'tarikh_tamat_penilaian' => 'required|date|after_or_equal:tarikh_mula_penilaian',
            ]);
            
            $data = array_merge($data, [
                'tarikh_mula_penilaian' => $request->tarikh_mula_penilaian,
                'tarikh_tamat_penilaian' => $request->tarikh_tamat_penilaian,
            ]);
        }
        
        EvaluationPeriod::create($data);
        
        return redirect()->route('evaluation-periods.index')
            ->with('success', 'Tempoh penilaian berjaya dicipta.');
    }

    public function show(EvaluationPeriod $evaluationPeriod)
    {
        return view('admin.evaluation_periods.show', compact('evaluationPeriod'));
    }

    public function edit(EvaluationPeriod $evaluationPeriod)
    {
        return view('admin.evaluation_periods.edit', compact('evaluationPeriod'));
    }

    public function update(Request $request, EvaluationPeriod $evaluationPeriod)
    {
        $request->validate([
            'tahun' => 'required|digits:4|integer|min:' . date('Y'),
        ]);

        $data = ['tahun' => $request->tahun];

        if ($evaluationPeriod->jenis === 'skt') {
            $request->validate([
                'tarikh_mula_awal' => 'required|date',
                'tarikh_tamat_awal' => 'required|date|after_or_equal:tarikh_mula_awal',

                'tarikh_mula_pertengahan' => 'required|date|after_or_equal:tarikh_tamat_awal',
                'tarikh_tamat_pertengahan' => 'required|date|after_or_equal:tarikh_mula_pertengahan',

                'tarikh_mula_akhir' => 'required|date|after_or_equal:tarikh_tamat_pertengahan',
                'tarikh_tamat_akhir' => 'required|date|after_or_equal:tarikh_mula_akhir',
            ]);

            $data = array_merge($data, [
                'tarikh_mula_awal' => $request->tarikh_mula_awal,
                'tarikh_tamat_awal' => $request->tarikh_tamat_awal,
                'tarikh_mula_pertengahan' => $request->tarikh_mula_pertengahan,
                'tarikh_tamat_pertengahan' => $request->tarikh_tamat_pertengahan,
                'tarikh_mula_akhir' => $request->tarikh_mula_akhir,
                'tarikh_tamat_akhir' => $request->tarikh_tamat_akhir,
            ]);
        } elseif ($evaluationPeriod->jenis === 'penilaian') {
            $request->validate([
                'tarikh_mula_penilaian' => 'required|date',
                'tarikh_tamat_penilaian' => 'required|date|after:tarikh_mula_penilaian',
            ]);

            $data = array_merge($data, [
                'tarikh_mula_penilaian' => $request->tarikh_mula_penilaian,
                'tarikh_tamat_penilaian' => $request->tarikh_tamat_penilaian,
            ]);
        }

        $evaluationPeriod->update($data);

        return redirect()->route('evaluation-periods.index')
            ->with('success', 'Tempoh penilaian berjaya dikemaskini.');
    }
}