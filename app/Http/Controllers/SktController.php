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
        } elseif ($user->isAdmin()) {
            // Admin can see all
        } else {
            abort(403);
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
        $evaluationPeriods = EvaluationPeriod::where('tahun', $currentYear)
            ->where('jenis', EvaluationPeriod::JENIS_SKT)
            ->get();

        // Get SKTs for these periods
        $assignedSkt = Skt::whereIn('evaluation_period_id', $evaluationPeriods->pluck('id'))->get();

        // Collect pyd_ids already assigned
        $assignedPydIds = $assignedSkt->pluck('pyd_id')->toArray();

        // Exclude assigned pyds
        $pyds = User::where('peranan', 'pyd')
            ->whereNotIn('id', $assignedPydIds)
            ->get();

        // Get all ppps without filtering
        $ppps = User::where('peranan', 'ppp')->get();

        return view('skt.create', compact('evaluationPeriods', 'pyds', 'ppps'));
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
        
        $ppps = User::where('peranan', 'ppp')->get();
        
        return view('skt.edit', compact('skt', 'ppps'));
    }

    public function update(Request $request, Skt $skt)
    {
        $this->authorize('update', $skt);
        
        if ($skt->status !== Skt::STATUS_DRAFT) {
            return redirect()->route('skt.show', $skt)
                ->with('error', 'Hanya SKT dalam draf boleh dikemaskini.');
        }
        
        $request->validate([
            'ppp_id' => 'required|exists:users,id',
        ]);
        
        $skt->update(['ppp_id' => $request->ppp_id]);
        
        return redirect()->route('skt.show', $skt)
            ->with('success', 'Penilai berjaya dikemaskini.');
    }

    public function destroy(Skt $skt)
    {
        $this->authorize('delete', $skt);
        
        $skt->delete();
        
        return redirect()->route('skt.index')
            ->with('success', 'SKT berjaya dipadam.');
    }

    public function submitAwal(Skt $skt, Request $request)
    {
        $this->authorize('submitAwal', $skt);
        
        $request->validate([
            'skt_awal' => 'required|array',
            'skt_awal.*.aktiviti' => 'required|string',
            'skt_awal.*.petunjuk' => 'required|string',
        ]);
        
        $skt->update([
            'skt_awal' => $request->skt_awal,
            'status' => Skt::STATUS_SUBMITTED_AWAL,
        ]);
        
        return redirect()->route('skt.show', $skt)
            ->with('success', 'SKT Awal Tahun berjaya diserahkan.');
    }

    public function approveAwal(Skt $skt)
    {
        $this->authorize('approveAwal', $skt);
        
        $skt->update([
            'skt_awal_approved_at' => now(),
            'status' => Skt::STATUS_APPROVED_AWAL,
        ]);
        
        return redirect()->route('skt.show', $skt)
            ->with('success', 'SKT Awal Tahun berjaya disahkan.');
    }

    public function submitPertengahan(Skt $skt, Request $request)
    {
        $this->authorize('submitPertengahan', $skt);
        
        $request->validate([
            'skt_pertengahan' => 'required|array',
            'skt_pertengahan.*.aktiviti' => 'required|string',
            'skt_pertengahan.*.petunjuk' => 'required|string',
        ]);
        
        $skt->update([
            'skt_pertengahan' => $request->skt_pertengahan,
            'status' => Skt::STATUS_SUBMITTED_PERTENGAHAN,
        ]);
        
        return redirect()->route('skt.show', $skt)
            ->with('success', 'SKT Pertengahan Tahun berjaya diserahkan.');
    }

    public function approvePertengahan(Skt $skt)
    {
        $this->authorize('approvePertengahan', $skt);
        
        $skt->update([
            'skt_pertengahan_approved_at' => now(),
            'status' => Skt::STATUS_APPROVED_PERTENGAHAN,
        ]);
        
        return redirect()->route('skt.show', $skt)
            ->with('success', 'SKT Pertengahan Tahun berjaya disahkan.');
    }

    public function submitAkhir(Skt $skt, Request $request)
    {
        $this->authorize('submitAkhir', $skt);
        
        $request->validate([
            'skt_akhir' => 'required|string',
        ]);
        
        $user = Auth::user();
        $field = $user->isPYD() ? 'skt_akhir_pyd' : 'skt_akhir_ppp';
        
        $data = [$field => $request->skt_akhir];
        
        // Check if both reports are completed
        if ($skt->skt_akhir_pyd && $skt->skt_akhir_ppp) {
            $data['status'] = Skt::STATUS_COMPLETED;
        } elseif (($user->isPYD() && $skt->skt_akhir_ppp) || ($user->isPPP() && $skt->skt_akhir_pyd)) {
            $data['status'] = Skt::STATUS_COMPLETED;
        }
        
        $skt->update($data);
        
        return redirect()->route('skt.show', $skt)
            ->with('success', 'Laporan akhir berjaya diserahkan.');
    }

    public function reopen(Skt $skt)
    {
        $this->authorize('reopen', $skt);
        
        if ($skt->current_phase === 'awal') {
            $skt->update(['status' => Skt::STATUS_DRAFT]);
        } elseif ($skt->current_phase === 'pertengahan') {
            $skt->update(['status' => Skt::STATUS_APPROVED_AWAL]);
        } elseif ($skt->current_phase === 'akhir') {
            $skt->update(['status' => Skt::STATUS_APPROVED_PERTENGAHAN]);
        }
        
        return redirect()->route('skt.show', $skt)
            ->with('success', 'SKT berjaya dibuka semula untuk pengisian.');
    }
}