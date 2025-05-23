<?php

namespace App\Http\Controllers;

use App\Models\Skt;
use App\Models\User;
use App\Models\EvaluationPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SktController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->input('year', date('Y'));
        
        $query = Skt::with(['pyd', 'ppp', 'evaluationPeriod'])
            ->whereHas('evaluationPeriod', function($q) use ($year) {
                $q->where('tahun', $year);
            });
        
        $user = Auth::user();
        
        if ($user->isPYD()) {
            $query->where('pyd_id', $user->id);
        } elseif ($user->isPPP()) {
            $query->where('ppp_id', $user->id);
        }
        
        $skts = $query->paginate(10);
        
        $availableYears = EvaluationPeriod::select('tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');
        
        return view('skt.index', compact('skts', 'availableYears', 'year'));
    }

    public function create()
    {
        $today = Carbon::today();

        // Active SKT periods
        $activeSktPeriods = EvaluationPeriod::where('jenis', EvaluationPeriod::JENIS_SKT)
            ->where(function ($query) use ($today) {
                $query->where(function ($q) use ($today) {
                    $q->whereDate('tarikh_mula_awal', '<=', $today)
                    ->whereDate('tarikh_tamat_awal', '>=', $today);
                })
                ->orWhere(function ($q) use ($today) {
                    $q->whereDate('tarikh_mula_pertengahan', '<=', $today)
                    ->whereDate('tarikh_tamat_pertengahan', '>=', $today);
                })
                ->orWhere(function ($q) use ($today) {
                    $q->whereDate('tarikh_mula_akhir', '<=', $today)
                    ->whereDate('tarikh_tamat_akhir', '>=', $today);
                });
            })
            ->get();

        // Active Penilaian periods
        $activePenilaianPeriods = EvaluationPeriod::where('jenis', EvaluationPeriod::JENIS_PENILAIAN)
            ->whereDate('tarikh_mula_penilaian', '<=', $today)
            ->whereDate('tarikh_tamat_penilaian', '>=', $today)
            ->get();

        // Combine both
        $periods = $activeSktPeriods->merge($activePenilaianPeriods);

        $pyds = User::where('peranan', 'pyd')->get();
        $ppps = User::where('peranan', 'ppp')->get();

        return view('skt.create', compact('periods', 'pyds', 'ppps'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'evaluation_period_id' => 'required|exists:evaluation_periods,id',
            'pyd_id' => 'required|exists:users,id',
            'ppp_id' => 'required|exists:users,id',
        ]);

        Skt::create([
            'evaluation_period_id' => $request->evaluation_period_id,
            'pyd_id' => $request->pyd_id,
            'ppp_id' => $request->ppp_id,
            'status' => 'draf', // Set to draft since PYD needs to fill details
        ]);

        return redirect()->route('skt.index')
            ->with('success', 'SKT berjaya dicipta. PYD perlu mengisi aktiviti dan petunjuk prestasi.');
    }

    public function show(Skt $skt)
    {
        return view('skt.show', compact('skt'));
    }

    public function edit(Skt $skt)
    {
        $periods = EvaluationPeriod::whereDate('tarikh_mula_penilaian', '<=', now())
            ->whereDate('tarikh_tamat_penilaian', '>=', now())
            ->get();
        $pyds = User::where('peranan', 'pyd')->get();
        $ppps = User::where('peranan', 'ppp')->get();
        
        return view('skt.edit', compact('skt', 'periods', 'pyds', 'ppps'));
    }

    public function update(Request $request, Skt $skt)
    {
        // Validate the input
        $validated = $request->validate([
            'aktiviti_projek' => 'required|array|min:1',
            'aktiviti_projek.*' => 'required|string',
            'petunjuk_prestasi' => 'required|array|min:1',
            'petunjuk_prestasi.*' => 'required|string',
            'tambahan_aktiviti' => 'nullable|array',
            'tambahan_aktiviti.*' => 'nullable|string',
            'tambahan_petunjuk' => 'nullable|array',
            'tambahan_petunjuk.*' => 'nullable|string',
            'guguran' => 'nullable|array',
            'guguran.*' => 'nullable|string',
            'laporan_akhir_pyd' => 'nullable|string',
        ]);

        // Prepare data for update
        $skt->aktiviti_projek = json_encode($validated['aktiviti_projek']);
        $skt->petunjuk_prestasi = json_encode($validated['petunjuk_prestasi']);

        // Mid-year additional items
        if ($skt->evaluationPeriod->active_period === 'pertengahan') {
            $tambahanAktiviti = $validated['tambahan_aktiviti'] ?? [];
            $tambahanPetunjuk = $validated['tambahan_petunjuk'] ?? [];
            $tambahan = [];

            foreach ($tambahanAktiviti as $i => $value) {
                $tambahan[] = [
                    'aktiviti' => $value ?? '',
                    'petunjuk' => $tambahanPetunjuk[$i] ?? '',
                ];
            }

            $skt->tambahan_pertengahan_tahun = json_encode($tambahan);
            $skt->guguran_pertengahan_tahun = json_encode($validated['guguran'] ?? []);
        }

        // End-of-year report
        if ($skt->evaluationPeriod->active_period === 'akhir') {
            $skt->laporan_akhir_pyd = $validated['laporan_akhir_pyd'] ?? null;
        }

        $skt->save();

        return redirect()->route('skt.show', $skt)->with('success', 'Maklumat SKT telah dikemaskini.');
    }

    public function destroy(Skt $skt)
    {
        $skt->delete();
        return redirect()->route('skt.index')
            ->with('success', 'SKT berjaya dipadam.');
    }

    public function submit(Skt $skt)
    {
        $skt->update(['status' => 'diserahkan']);
        return redirect()->route('skt.index')
            ->with('success', 'SKT berjaya diserahkan.');
    }

    public function approve(Skt $skt)
    {
        $skt->update(['status' => 'disahkan']);
        return redirect()->route('skt.index')
            ->with('success', 'SKT berjaya disahkan.');
    }

    public function midYearReview(Request $request, Skt $skt)
    {
        $request->validate([
            'tambahan_pertengahan_tahun' => 'nullable|string',
            'guguran_pertengahan_tahun' => 'nullable|string',
        ]);

        $skt->update([
            'tambahan_pertengahan_tahun' => $request->tambahan_pertengahan_tahun,
            'guguran_pertengahan_tahun' => $request->guguran_pertengahan_tahun,
        ]);

        return redirect()->route('skt.show', $skt)
            ->with('success', 'Kajian semula pertengahan tahun berjaya dikemaskini.');
    }

    public function finalReview(Request $request, Skt $skt)
    {
        $user = Auth::user();
        $request->validate([
            'laporan_akhir' => 'required|string',
        ]);

        if ($user->isPYD()) {
            $skt->update(['laporan_akhir_pyd' => $request->laporan_akhir]);
        } elseif ($user->isPPP()) {
            $skt->update(['ulasan_akhir_ppp' => $request->laporan_akhir]);
        }

        return redirect()->route('skt.show', $skt)
            ->with('success', 'Laporan akhir berjaya dikemaskini.');
    }
}