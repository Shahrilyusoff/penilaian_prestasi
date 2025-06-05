<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Skt;
use App\Models\Evaluation;
use App\Models\EvaluationPeriod;
use App\Models\Activity;
use Carbon\Carbon;

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
            return $this->adminDashboard();
        } elseif ($user->isPPP()) {
            return $this->pppDashboard();
        } elseif ($user->isPPK()) {
            return $this->ppkDashboard();
        } elseif ($user->isPYD()) {
            return $this->pydDashboard();
        }
        
        return redirect('/');
    }

    protected function adminDashboard()
    {
        $currentYear = date('Y');
        
        // Active evaluation periods
        $activePeriods = EvaluationPeriod::whereDate('tarikh_mula_awal', '<=', now())
            ->whereDate('tarikh_tamat_akhir', '>=', now())
            ->get();

        // Submitted SKTs
        $submittedSkts = Skt::whereIn('status', [
            Skt::STATUS_SUBMITTED_AWAL, 
            Skt::STATUS_SUBMITTED_PERTENGAHAN
        ])->count();

        // Completed evaluations
        $completedEvaluations = Evaluation::where('status', 'selesai')->count();

        // Total users
        $totalUsers = User::count();

        // Recent activities
        $recentActivities = [];
        if (class_exists(Activity::class)) {
            $recentActivities = Activity::with('causer')
                ->latest()
                ->take(5)
                ->get();
        }

        // Pending SKTs (not submitted)
        $pendingSkts = Skt::where('status', Skt::STATUS_NOT_SUBMITTED)
            ->whereHas('evaluationPeriod', function($q) use ($currentYear) {
                $q->where('tahun', $currentYear);
            })
            ->count();

        return view('admin.dashboard', compact(
            'activePeriods',
            'submittedSkts',
            'completedEvaluations',
            'totalUsers',
            'recentActivities',
            'pendingSkts'
        ));
    }

    protected function pppDashboard()
    {
        $user = Auth::user();
        $currentYear = date('Y');

        // Pending SKTs for approval
        $pendingSkts = Skt::where('ppp_id', $user->id)
            ->whereIn('status', [
                Skt::STATUS_SUBMITTED_AWAL,
                Skt::STATUS_SUBMITTED_PERTENGAHAN
            ])
            ->whereHas('evaluationPeriod', function($q) use ($currentYear) {
                $q->where('tahun', $currentYear);
            })
            ->with('pyd')
            ->get();

        // Pending evaluations
        $pendingEvaluations = Evaluation::where('ppp_id', $user->id)
            ->where('status', 'draf_ppp')
            ->whereHas('evaluationPeriod', function($q) use ($currentYear) {
                $q->where('tahun', $currentYear);
            })
            ->with('pyd')
            ->get();

        // Active periods
        $activePeriods = EvaluationPeriod::whereDate('tarikh_mula_awal', '<=', now())
            ->whereDate('tarikh_tamat_akhir', '>=', now())
            ->where('tahun', $currentYear)
            ->get();

        return view('ppp.dashboard', compact(
            'pendingSkts',
            'pendingEvaluations',
            'activePeriods'
        ));
    }

    protected function ppkDashboard()
    {
        $user = Auth::user();
        $currentYear = date('Y');

        // Pending evaluations for approval
        $pendingEvaluations = Evaluation::where('ppk_id', $user->id)
            ->where('status', 'draf_ppk')
            ->whereHas('evaluationPeriod', function($q) use ($currentYear) {
                $q->where('tahun', $currentYear);
            })
            ->with(['pyd', 'ppp'])
            ->get();

        // Active periods
        $activePeriods = EvaluationPeriod::whereDate('tarikh_mula_awal', '<=', now())
            ->whereDate('tarikh_tamat_akhir', '>=', now())
            ->where('tahun', $currentYear)
            ->get();

        return view('ppk.dashboard', compact(
            'pendingEvaluations',
            'activePeriods'
        ));
    }

    protected function pydDashboard()
    {
        $user = Auth::user();
        $currentYear = date('Y');

        // Current SKTs
        $currentSkts = Skt::where('pyd_id', $user->id)
            ->whereHas('evaluationPeriod', function($q) use ($currentYear) {
                $q->where('tahun', $currentYear);
            })
            ->with(['ppp', 'evaluationPeriod'])
            ->get();

        // Pending evaluations
        $pendingEvaluations = Evaluation::where('pyd_id', $user->id)
            ->where('status', 'draf_pyd')
            ->whereHas('evaluationPeriod', function($q) use ($currentYear) {
                $q->where('tahun', $currentYear);
            })
            ->with(['ppp', 'ppk'])
            ->get();

        // Active periods
        $activePeriods = EvaluationPeriod::whereDate('tarikh_mula_awal', '<=', now())
            ->whereDate('tarikh_tamat_akhir', '>=', now())
            ->where('tahun', $currentYear)
            ->get();

        // Check for overdue tasks
        $overdueSkts = Skt::where('pyd_id', $user->id)
            ->where('status', Skt::STATUS_DRAFT)
            ->whereHas('evaluationPeriod', function($q) {
                $q->whereDate('tarikh_tamat_awal', '<', now())
                  ->orWhereDate('tarikh_tamat_akhir', '<', now());
            })
            ->count();

        return view('pyd.dashboard', compact(
            'currentSkts',
            'pendingEvaluations',
            'activePeriods',
            'overdueSkts'
        ));
    }
}