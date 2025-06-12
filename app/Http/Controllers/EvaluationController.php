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
        $evaluationPeriods = EvaluationPeriod::where('jenis', 'penilaian')
            ->orderBy('tahun', 'desc')
            ->get();

        // Get all evaluation period IDs
        $periodIds = $evaluationPeriods->pluck('id')->toArray();

        // Get PYD IDs already assigned in any evaluation for these periods
        $assignedPydIds = Evaluation::whereIn('evaluation_period_id', $periodIds)
            ->pluck('pyd_id')
            ->toArray();

        // Get PYDs excluding those already assigned
        $pyds = User::where('peranan', 'pyd')
            ->whereNotIn('id', $assignedPydIds)
            ->get();

        $ppps = User::where('peranan', 'ppp')->get();
        $ppks = User::where('peranan', 'ppk')->get();

        return view('evaluations.create', compact('evaluationPeriods', 'pyds', 'ppps', 'ppks'));
    }

public function store(Request $request)
{
    // Check if batch input exists (from your create form)
    $isBatch = $request->has('pyd_ids');

    if ($isBatch) {
        // ✅ Batch Validation
        $request->validate([
            'evaluation_period_id' => 'required|exists:evaluation_periods,id',
            'pyd_ids' => 'required|array',
            'pyd_ids.*' => 'exists:users,id',
            'ppp_ids' => 'required|array',
            'ppp_ids.*' => 'exists:users,id',
            'ppk_ids' => 'required|array',
            'ppk_ids.*' => 'exists:users,id',
        ]);

        // ✅ Prevent duplicate PYD assignment
        if (count($request->pyd_ids) !== count(array_unique($request->pyd_ids))) {
            return back()->withErrors(['pyd_ids' => 'PYD tidak boleh diulang'])->withInput();
        }

        // ✅ Loop through each PYD to create evaluations
        foreach ($request->pyd_ids as $index => $pydId) {
            $evaluation = Evaluation::create([
                'evaluation_period_id' => $request->evaluation_period_id,
                'pyd_id' => $pydId,
                'ppp_id' => $request->ppp_ids[$index],
                'ppk_id' => $request->ppk_ids[$index],
                'status' => Evaluation::STATUS_DRAFT_PYD,
            ]);

            $pydGroup = User::find($pydId)->pydGroup->nama_kumpulan ?? null;

            $criteria = EvaluationCriteria::where('kumpulan_pyd', $pydGroup)
                ->orWhereNull('kumpulan_pyd')
                ->get();

            foreach ($criteria as $criterion) {
                EvaluationScore::create([
                    'evaluation_id' => $evaluation->id,
                    'criteria_id' => $criterion->id,
                ]);
            }
        }

        return redirect()->route('evaluations.index')
            ->with('success', 'Penilaian berjaya dicipta untuk semua PYD.');
    }

    // ✅ Single creation fallback (optional)
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
        'status' => Evaluation::STATUS_DRAFT_PYD,
    ]);

    $pydGroup = User::find($request->pyd_id)->pydGroup->nama_kumpulan ?? null;

    $criteria = EvaluationCriteria::where('kumpulan_pyd', $pydGroup)
        ->orWhereNull('kumpulan_pyd')
        ->get();

    foreach ($criteria as $criterion) {
        EvaluationScore::create([
            'evaluation_id' => $evaluation->id,
            'criteria_id' => $criterion->id,
        ]);
    }

    return redirect()->route('evaluations.show', [$evaluation, 'step' => 'I'])
        ->with('success', 'Penilaian berjaya dicipta.');
}


    public function show(Evaluation $evaluation)
    {
        $scores = $evaluation->calculateSectionScores();
        return view('evaluations.show', compact('evaluation', 'scores'));
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

    public function updateBahagian(Request $request, Evaluation $evaluation, $bahagian)
    {
        $user = Auth::user();

        if (!$evaluation->canEditBahagian($bahagian, $user)) {
            abort(403, 'Anda tidak dibenarkan mengemaskini bahagian ini.');
        }

        switch ($bahagian) {
            case 'II':
                return $this->updateBahagianII($request, $evaluation);
            case 'III':
            case 'IV':
            case 'V':
            case 'VI':
                return $this->updateMarkah($request, $evaluation, $bahagian, $user);
            case 'VIII':
                return $this->updateBahagianVIII($request, $evaluation, $user);
            case 'IX':
                return $this->updateBahagianIX($request, $evaluation, $user);
            default:
                return back()->with('error', 'Bahagian tidak sah.');
        }
    }

    protected function updateBahagianII(Request $request, Evaluation $evaluation)
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
        ]);

        return back()->with('success', 'Bahagian II berjaya dikemaskini.');
    }

    protected function updateMarkah(Request $request, Evaluation $evaluation, $bahagian, $user)
    {
        $markahField = $user->isPPP() ? 'markah_ppp' : 'markah_ppk';

        foreach ($request->markah as $scoreId => $markah) {
            $score = EvaluationScore::findOrFail($scoreId);
            $criteria = $score->criteria;

            if ($criteria->bahagian === $bahagian) {
                $score->update([$markahField => $markah]);
            }
        }

        return back()->with('success', "Bahagian $bahagian berjaya dikemaskini.");
    }

    protected function updateBahagianVIII(Request $request, Evaluation $evaluation, $user)
    {
        $request->validate([
            'tempoh_penilaian_mula' => 'required|date',
            'tempoh_penilaian_tamat' => 'required|date|after:tempoh_penilaian_mula',
            'ulasan_keseluruhan' => 'required|string',
            'kemajuan_kerjaya' => 'required|string',
        ]);

        if ($user->isPPP()) {
            $evaluation->update([
                'tempoh_penilaian_ppp_mula' => $request->tempoh_penilaian_mula,
                'tempoh_penilaian_ppp_tamat' => $request->tempoh_penilaian_tamat,
                'ulasan_keseluruhan_ppp' => $request->ulasan_keseluruhan,
                'kemajuan_kerjaya_ppp' => $request->kemajuan_kerjaya,
            ]);
        }

        return back()->with('success', 'Bahagian VIII berjaya dikemaskini.');
    }

    protected function updateBahagianIX(Request $request, Evaluation $evaluation, $user)
    {
        $request->validate([
            'tempoh_penilaian_mula' => 'required|date',
            'tempoh_penilaian_tamat' => 'required|date|after:tempoh_penilaian_mula',
            'ulasan_keseluruhan' => 'required|string',
        ]);

        if ($user->isPPK()) {
            $evaluation->update([
                'tempoh_penilaian_ppk_mula' => $request->tempoh_penilaian_mula,
                'tempoh_penilaian_ppk_tamat' => $request->tempoh_penilaian_tamat,
                'ulasan_keseluruhan_ppk' => $request->ulasan_keseluruhan,
            ]);
        }

        return back()->with('success', 'Bahagian IX berjaya dikemaskini.');
    }

    public function submit(Request $request, Evaluation $evaluation)
    {
        $user = Auth::user();

        if (!$evaluation->canSubmit($user)) {
            abort(403, 'Anda tidak dibenarkan menghantar penilaian ini.');
        }

        $evaluation->update([
            'status' => $evaluation->getNextStatus(),
        ]);

        return redirect()->route('evaluations.show', $evaluation)
            ->with('success', 'Penilaian berjaya diserahkan.');
    }

    public function reopen(Request $request, Evaluation $evaluation)
    {
        if (!Auth::user()->isSuperAdmin() && !Auth::user()->isAdmin()) {
            abort(403, 'Hanya pentadbir dibenarkan membuka semula penilaian.');
        }

        $request->validate([
            'new_status' => 'required|in:draf_pyd,draf_ppp,draf_ppk',
        ]);

        $evaluation->update([
            'status' => $request->new_status,
        ]);

        return back()->with('success', 'Penilaian berjaya dibuka semula.');
    }
}