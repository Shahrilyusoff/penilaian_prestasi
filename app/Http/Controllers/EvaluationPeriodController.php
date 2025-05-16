<?php

namespace App\Http\Controllers;

use App\Models\EvaluationPeriod;
use Illuminate\Http\Request;

class EvaluationPeriodController extends Controller
{
    public function index()
    {
        $periods = EvaluationPeriod::all();
        return view('admin.evaluation_periods.index', compact('periods'));
    }

    public function create()
    {
        return view('admin.evaluation_periods.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun' => 'required|string|max:255',
            'tarikh_mula' => 'required|date',
            'tarikh_tamat' => 'required|date|after:tarikh_mula',
        ]);

        EvaluationPeriod::create([
            'tahun' => $request->tahun,
            'tarikh_mula' => $request->tarikh_mula,
            'tarikh_tamat' => $request->tarikh_tamat,
            'status' => $request->has('status'),
            'boleh_ubah_selepas_tamat' => $request->has('boleh_ubah_selepas_tamat'),
        ]);

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
            'tahun' => 'required|string|max:255',
            'tarikh_mula' => 'required|date',
            'tarikh_tamat' => 'required|date|after:tarikh_mula',
        ]);

        $evaluationPeriod->update([
            'tahun' => $request->tahun,
            'tarikh_mula' => $request->tarikh_mula,
            'tarikh_tamat' => $request->tarikh_tamat,
            'status' => $request->has('status'),
            'boleh_ubah_selepas_tamat' => $request->has('boleh_ubah_selepas_tamat'),
        ]);

        return redirect()->route('evaluation-periods.index')
            ->with('success', 'Tempoh penilaian berjaya dikemaskini.');
    }

    public function destroy(EvaluationPeriod $evaluationPeriod)
    {
        $evaluationPeriod->delete();
        return redirect()->route('evaluation-periods.index')
            ->with('success', 'Tempoh penilaian berjaya dipadam.');
    }
}