<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use App\Models\EvaluationScore;
use App\Models\EvaluationCriteria;
use App\Models\EvaluationPeriod;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EvaluationController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->input('year', date('Y'));
        
        $query = Evaluation::with(['pyd', 'ppp', 'ppk', 'evaluationPeriod'])
            ->whereHas('evaluationPeriod', function($q) use ($year) {
                $q->where('tahun', $year);
            });
        
        $user = Auth::user();
        
        if ($user->isPYD()) {
            $query->where('pyd_id', $user->id);
        } elseif ($user->isPPP()) {
            $query->where('ppp_id', $user->id);
        } elseif ($user->isPPK()) {
            $query->where('ppk_id', $user->id);
        }
        
        $evaluations = $query->paginate(10);
        
        $availableYears = EvaluationPeriod::select('tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');
        
        return view('evaluations.index', compact('evaluations', 'availableYears', 'year'));
    }

    public function create()
    {
        $periods = EvaluationPeriod::whereDate('tarikh_mula', '<=', now())
            ->whereDate('tarikh_tamat', '>=', now())
            ->get();
        $pyds = User::where('peranan', 'pyd')->get();
        $ppps = User::where('peranan', 'ppp')->get();
        $ppks = User::where('peranan', 'ppk')->get();
        
        return view('evaluations.create', compact('periods', 'pyds', 'ppps', 'ppks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'evaluation_period_id' => 'required|exists:evaluation_periods,id',
            'pyd_id' => 'required|exists:users,id',
            'ppp_id' => 'required|exists:users,id',
            'ppk_id' => 'required|exists:users,id',
        ]);

        $evaluation = Evaluation::create([
            'evaluation_period_id' => $request->evaluation_period_id,
            'pyd_id' => $request->pyd_id,
            'ppp_id' => $request->ppp_id,
            'ppk_id' => $request->ppk_id,
            'status' => 'draf_pyd',
        ]);

        // Create empty scores for all criteria
        $pydGroup = User::find($request->pyd_id)->pydGroup->nama_kumpulan;
        $criteria = EvaluationCriteria::where('kumpulan_pyd', $pydGroup)
            ->orWhereNull('kumpulan_pyd')
            ->get();

        foreach ($criteria as $criterion) {
            EvaluationScore::create([
                'evaluation_id' => $evaluation->id,
                'criteria_id' => $criterion->id,
            ]);
        }

        return redirect()->route('evaluations.index')
            ->with('success', 'Penilaian berjaya dicipta.');
    }

    public function show(Evaluation $evaluation)
    {
        $totalScores = $evaluation->calculateTotalScore();
        return view('evaluations.show', compact('evaluation', 'totalScores'));
    }

    public function edit(Evaluation $evaluation)
    {
        $periods = EvaluationPeriod::where('status', true)->get();
        $pyds = User::where('peranan', 'pyd')->get();
        $ppps = User::where('peranan', 'ppp')->get();
        $ppks = User::where('peranan', 'ppk')->get();
        
        return view('evaluations.edit', compact('evaluation', 'periods', 'pyds', 'ppps', 'ppks'));
    }

    public function update(Request $request, Evaluation $evaluation)
    {
        $request->validate([
            'evaluation_period_id' => 'required|exists:evaluation_periods,id',
            'pyd_id' => 'required|exists:users,id',
            'ppp_id' => 'required|exists:users,id',
            'ppk_id' => 'required|exists:users,id',
        ]);

        $evaluation->update([
            'evaluation_period_id' => $request->evaluation_period_id,
            'pyd_id' => $request->pyd_id,
            'ppp_id' => $request->ppp_id,
            'ppk_id' => $request->ppk_id,
        ]);

        return redirect()->route('evaluations.index')
            ->with('success', 'Penilaian berjaya dikemaskini.');
    }

    public function destroy(Evaluation $evaluation)
    {
        $evaluation->delete();
        return redirect()->route('evaluations.index')
            ->with('success', 'Penilaian berjaya dipadam.');
    }

    public function submitPYD(Request $request, Evaluation $evaluation)
    {
        $request->validate([
            'kegiatan_sumbangan' => 'required|string',
            'latihan_dihadiri' => 'required|string',
            'latihan_diperlukan' => 'required|string',
        ]);

        $evaluation->update([
            'kegiatan_sumbangan' => $request->kegiatan_sumbangan,
            'latihan_dihadiri' => $request->latihan_dihadiri,
            'latihan_diperlukan' => $request->latihan_diperlukan,
            'status' => 'draf_ppp',
        ]);

        return redirect()->route('evaluations.show', $evaluation)
            ->with('success', 'Bahagian II berjaya diserahkan untuk penilaian PPP.');
    }

    public function submitPPP(Request $request, Evaluation $evaluation)
    {
        $request->validate([
            'markah_ppp.*' => 'required|integer|min:1|max:10',
            'tempoh_penilaian_ppp_mula' => 'required|date',
            'tempoh_penilaian_ppp_tamat' => 'required|date|after:tempoh_penilaian_ppp_mula',
            'ulasan_keseluruhan_ppp' => 'required|string',
            'kemajuan_kerjaya_ppp' => 'required|string',
        ]);

        // Update scores
        foreach ($request->markah_ppp as $scoreId => $markah) {
            EvaluationScore::find($scoreId)->update(['markah_ppp' => $markah]);
        }

        $evaluation->update([
            'tempoh_penilaian_ppp_mula' => $request->tempoh_penilaian_ppp_mula,
            'tempoh_penilaian_ppp_tamat' => $request->tempoh_penilaian_ppp_tamat,
            'ulasan_keseluruhan_ppp' => $request->ulasan_keseluruhan_ppp,
            'kemajuan_kerjaya_ppp' => $request->kemajuan_kerjaya_ppp,
            'status' => 'draf_ppk',
        ]);

        return redirect()->route('evaluations.show', $evaluation)
            ->with('success', 'Penilaian berjaya diserahkan untuk penilaian PPK.');
    }

    public function submitPPK(Request $request, Evaluation $evaluation)
    {
        $request->validate([
            'markah_ppk.*' => 'required|integer|min:1|max:10',
            'tempoh_penilaian_ppk_mula' => 'required|date',
            'tempoh_penilaian_ppk_tamat' => 'required|date|after:tempoh_penilaian_ppk_mula',
            'ulasan_keseluruhan_ppk' => 'required|string',
        ]);

        // Update scores
        foreach ($request->markah_ppk as $scoreId => $markah) {
            EvaluationScore::find($scoreId)->update(['markah_ppk' => $markah]);
        }

        $evaluation->update([
            'tempoh_penilaian_ppk_mula' => $request->tempoh_penilaian_ppk_mula,
            'tempoh_penilaian_ppk_tamat' => $request->tempoh_penilaian_ppk_tamat,
            'ulasan_keseluruhan_ppk' => $request->ulasan_keseluruhan_ppk,
            'status' => 'selesai',
        ]);

        return redirect()->route('evaluations.show', $evaluation)
            ->with('success', 'Penilaian berjaya diselesaikan.');
    }
}