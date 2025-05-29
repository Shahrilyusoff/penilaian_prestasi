<?php

namespace App\Http\Controllers;

use App\Models\Skt;
use App\Models\User;
use App\Models\EvaluationPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $this->authorize('create', Skt::class);

        $currentYear = date('Y');

        // Get the SKT evaluation periods for current year
        $evaluationPeriods = EvaluationPeriod::skt()->currentYear()->get();

        // If you want to exclude PYDs that already have SKT in *any* current year SKT period,
        // collect all evaluation_period_ids from $evaluationPeriods first:
        $evaluationPeriodIds = $evaluationPeriods->pluck('id')->toArray();

        // Get PYD IDs already assigned SKT for current year's evaluation periods
        $assignedPydIds = Skt::whereIn('evaluation_period_id', $evaluationPeriodIds)
                            ->pluck('pyd_id')
                            ->toArray();

        // Exclude assigned PYDs from selectable list
        $pyds = User::where('peranan', 'pyd')
                    ->whereNotIn('id', $assignedPydIds)
                    ->get();

        $ppps = User::where('peranan', 'ppp')->get();

        return view('skt.create', compact('pyds', 'ppps', 'evaluationPeriods', 'currentYear'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Skt::class);

        $request->validate([
            'evaluation_period_id' => 'required|exists:evaluation_periods,id',
            'pyd_ids' => 'required|array|min:1',
            'pyd_ids.*' => 'required|exists:users,id',
            'ppp_ids' => 'required|array|min:1',
            'ppp_ids.*' => 'required|exists:users,id',
        ]);

        foreach ($request->pyd_ids as $index => $pydId) {
            Skt::create([
                'evaluation_period_id' => $request->evaluation_period_id,
                'pyd_id' => $pydId,
                'ppp_id' => $request->ppp_ids[$index],
                'status' => Skt::STATUS_DRAFT,
            ]);
        }

        return redirect()->route('skt.index')
            ->with('success', 'SKT berjaya dicipta.');
    }

    public function show(Skt $skt)
    {
        $this->authorize('view', $skt);
        
        return view('skt.show', compact('skt'));
    }

    public function edit(Skt $skt)
    {
        $this->authorize('update', $skt);
        
        if ($skt->isAwalTahunActive()) {
            return view('skt.edit-awal', compact('skt'));
        } elseif ($skt->isPertengahanTahunActive()) {
            return view('skt.edit-pertengahan', compact('skt'));
        } elseif ($skt->isAkhirTahunActive()) {
            return view('skt.edit-akhir', compact('skt'));
        }
        
        return redirect()->route('skt.show', $skt)
            ->with('error', 'Tempoh SKT tidak aktif.');
    }

    public function update(Request $request, Skt $skt)
    {
        $this->authorize('update', $skt);
        
        if ($skt->isAwalTahunActive()) {
            return $this->updateAwalTahun($request, $skt);
        } elseif ($skt->isPertengahanTahunActive()) {
            return $this->updatePertengahanTahun($request, $skt);
        } elseif ($skt->isAkhirTahunActive()) {
            return $this->updateAkhirTahun($request, $skt);
        }
        
        return redirect()->route('skt.show', $skt)
            ->with('error', 'Tempoh SKT tidak aktif.');
    }

    protected function updateAwalTahun(Request $request, Skt $skt)
    {
        $request->validate([
            'aktiviti_projek' => 'required|array',
            'aktiviti_projek.*' => 'required|string',
            'petunjuk_prestasi' => 'required|array',
            'petunjuk_prestasi.*' => 'required|string',
        ]);
        
        $aktivitiProjek = array_values($request->aktiviti_projek);
        $petunjukPrestasi = array_values($request->petunjuk_prestasi);
        
        $combined = [];
        for ($i = 0; $i < count($aktivitiProjek); $i++) {
            $combined[] = [
                'aktiviti' => $aktivitiProjek[$i],
                'petunjuk' => $petunjukPrestasi[$i] ?? '',
            ];
        }
        
        $skt->update([
            'aktiviti_projek' => json_encode($combined),
            'status' => Skt::STATUS_SUBMITTED,
        ]);
        
        return redirect()->route('skt.show', $skt)
            ->with('success', 'SKT Awal Tahun berjaya diserahkan.');
    }

    protected function updatePertengahanTahun(Request $request, Skt $skt)
    {
        $request->validate([
            'aktiviti_projek' => 'required|array',
            'aktiviti_projek.*' => 'required|string',
            'petunjuk_prestasi' => 'required|array',
            'petunjuk_prestasi.*' => 'required|string',
        ]);
        
        $aktivitiProjek = array_values($request->aktiviti_projek);
        $petunjukPrestasi = array_values($request->petunjuk_prestasi);
        
        $combined = [];
        for ($i = 0; $i < count($aktivitiProjek); $i++) {
            $combined[] = [
                'aktiviti' => $aktivitiProjek[$i],
                'petunjuk' => $petunjukPrestasi[$i] ?? '',
            ];
        }
        
        $skt->update([
            'aktiviti_projek' => json_encode($combined),
            'status' => Skt::STATUS_SUBMITTED,
        ]);
        
        return redirect()->route('skt.show', $skt)
            ->with('success', 'SKT Pertengahan Tahun berjaya diserahkan.');
    }

    protected function updateAkhirTahun(Request $request, Skt $skt)
    {
        $user = Auth::user();
        $request->validate([
            'laporan_akhir' => 'required|string',
        ]);
        
        if ($user->isPYD()) {
            $skt->update([
                'laporan_akhir_pyd' => $request->laporan_akhir,
            ]);
            
            $message = 'Laporan akhir PYD berjaya dikemaskini.';
        } elseif ($user->isPPP()) {
            $skt->update([
                'ulasan_akhir_ppp' => $request->laporan_akhir,
            ]);
            
            $message = 'Ulasan akhir PPP berjaya dikemaskini.';
        }
        
        // Check if both have submitted
        if ($skt->laporan_akhir_pyd && $skt->ulasan_akhir_ppp) {
            $skt->update(['status' => Skt::STATUS_COMPLETED]);
            $message = 'SKT Akhir Tahun telah selesai.';
        }
        
        return redirect()->route('skt.show', $skt)
            ->with('success', $message);
    }

    public function destroy(Skt $skt)
    {
        $this->authorize('delete', $skt);
        
        $skt->delete();
        
        return redirect()->route('skt.index')
            ->with('success', 'SKT berjaya dipadam.');
    }

    public function approve(Skt $skt)
    {
        $this->authorize('approve', $skt);
        
        $skt->update(['status' => Skt::STATUS_APPROVED]);
        
        return redirect()->route('skt.show', $skt)
            ->with('success', 'SKT berjaya disahkan.');
    }
}