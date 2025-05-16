<?php

namespace App\Http\Controllers;

use App\Models\Skt;
use App\Models\User;
use App\Models\EvaluationPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SktController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->isPYD()) {
            $skts = Skt::with(['pyd', 'ppp', 'evaluationPeriod'])
                ->where('pyd_id', $user->id)
                ->paginate(10);
        } elseif ($user->isPPP()) {
            $skts = Skt::with(['pyd', 'ppp', 'evaluationPeriod'])
                ->where('ppp_id', $user->id)
                ->paginate(10);
        } else {
            $skts = Skt::with(['pyd', 'ppp', 'evaluationPeriod'])
                ->paginate(10);
        }

        return view('skt.index', compact('skts'));
    }


    public function create()
    {
        $periods = EvaluationPeriod::where('status', true)->get();
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
            'aktiviti_projek' => 'required|string',
            'petunjuk_prestasi' => 'required|string',
        ]);

        Skt::create([
            'evaluation_period_id' => $request->evaluation_period_id,
            'pyd_id' => $request->pyd_id,
            'ppp_id' => $request->ppp_id,
            'aktiviti_projek' => $request->aktiviti_projek,
            'petunjuk_prestasi' => $request->petunjuk_prestasi,
            'status' => 'draf',
        ]);

        return redirect()->route('skt.index')
            ->with('success', 'SKT berjaya dicipta.');
    }

    public function show(Skt $skt)
    {
        return view('skt.show', compact('skt'));
    }

    public function edit(Skt $skt)
    {
        $periods = EvaluationPeriod::where('status', true)->get();
        $pyds = User::where('peranan', 'pyd')->get();
        $ppps = User::where('peranan', 'ppp')->get();
        
        return view('skt.edit', compact('skt', 'periods', 'pyds', 'ppps'));
    }

    public function update(Request $request, Skt $skt)
    {
        $request->validate([
            'evaluation_period_id' => 'required|exists:evaluation_periods,id',
            'pyd_id' => 'required|exists:users,id',
            'ppp_id' => 'required|exists:users,id',
            'aktiviti_projek' => 'required|string',
            'petunjuk_prestasi' => 'required|string',
        ]);

        $skt->update([
            'evaluation_period_id' => $request->evaluation_period_id,
            'pyd_id' => $request->pyd_id,
            'ppp_id' => $request->ppp_id,
            'aktiviti_projek' => $request->aktiviti_projek,
            'petunjuk_prestasi' => $request->petunjuk_prestasi,
        ]);

        return redirect()->route('skt.index')
            ->with('success', 'SKT berjaya dikemaskini.');
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