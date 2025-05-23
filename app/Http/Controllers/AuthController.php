<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\EvaluationPeriod;  
use App\Models\Skt;               
use App\Models\Evaluation;        
use Spatie\Activitylog\Models\Activity;          

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'Emel atau kata laluan tidak sah.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function dashboard()
    {
        $user = Auth::user();
        
        if ($user->isSuperAdmin() || $user->isAdmin()) {
            $today = now();

            $activePeriods = EvaluationPeriod::where(function ($query) use ($today) {
                $query->where(function ($q) use ($today) {
                    $q->where('jenis', 'skt')
                        ->whereDate('tarikh_mula_awal', '<=', $today)
                        ->whereDate('tarikh_tamat_akhir', '>=', $today);
                })->orWhere(function ($q) use ($today) {
                    $q->where('jenis', 'penilaian')
                        ->whereDate('tarikh_mula_penilaian', '<=', $today)
                        ->whereDate('tarikh_tamat_penilaian', '>=', $today);
                });
            })->get();

            $submittedSkts = Skt::where('status', 'diserahkan')->count();
            $completedEvaluations = Evaluation::where('status', 'selesai')->count();
            $totalUsers = User::count();
            
            // Get recent activities if activitylog is installed
            $recentActivities = [];
            if (class_exists(\Spatie\Activitylog\Models\Activity::class)) {
                $recentActivities = \Spatie\Activitylog\Models\Activity::with('causer')
                    ->latest()
                    ->take(5)
                    ->get();
            }
            
            return view('admin.dashboard', compact(
                'activePeriods',
                'submittedSkts',
                'completedEvaluations',
                'totalUsers',
                'recentActivities'
            ));
        } elseif ($user->isPPP()) {
            $pendingSkts = Skt::where('ppp_id', $user->id)
                ->where('status', 'diserahkan')
                ->with(['pyd', 'evaluationPeriod'])
                ->get();
                
            $pendingEvaluations = Evaluation::where('ppp_id', $user->id)
                ->where('status', 'draf_ppp')
                ->with(['pyd', 'evaluationPeriod'])
                ->get();
                
            $recentEvaluations = Evaluation::where('ppp_id', $user->id)
                ->whereIn('status', ['draf_ppk', 'selesai'])
                ->with(['pyd', 'evaluationPeriod'])
                ->latest()
                ->take(5)
                ->get();
                
            return view('ppp.dashboard', compact('pendingSkts', 'pendingEvaluations', 'recentEvaluations'));
        } elseif ($user->isPPK()) {
            $pendingEvaluations = Evaluation::where('ppk_id', $user->id)
                ->where('status', 'draf_ppk')
                ->with(['pyd', 'ppp', 'evaluationPeriod'])
                ->get();
                
            $recentEvaluations = Evaluation::where('ppk_id', $user->id)
                ->where('status', 'selesai')
                ->with(['pyd', 'ppp', 'evaluationPeriod'])
                ->latest()
                ->take(5)
                ->get();
                
            return view('ppk.dashboard', compact('pendingEvaluations', 'recentEvaluations'));
        } elseif ($user->isPYD()) {
            $pendingSkts = Skt::where('pyd_id', $user->id)
                ->where('status', 'draf')
                ->with(['ppp', 'evaluationPeriod'])
                ->get();
                
            $pendingEvaluations = Evaluation::where('pyd_id', $user->id)
                ->where('status', 'draf_pyd')
                ->with(['ppp', 'ppk', 'evaluationPeriod'])
                ->get();
                
            $recentEvaluations = Evaluation::where('pyd_id', $user->id)
                ->where('status', 'selesai')
                ->with(['ppp', 'ppk', 'evaluationPeriod'])
                ->latest()
                ->take(5)
                ->get();
                
            return view('pyd.dashboard', compact('pendingSkts', 'pendingEvaluations', 'recentEvaluations'));
        }
        
        return redirect('/');
    }
    
}