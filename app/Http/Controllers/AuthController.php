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
            $activePeriods = EvaluationPeriod::where('status', true)->get();
            $submittedSkts = Skt::where('status', 'diserahkan')->count();
            $completedEvaluations = Evaluation::where('status', 'selesai')->count();
            $totalUsers = User::count();
            
            // Get recent activities (if activitylog is installed)
            $recentActivities = [];
            if (class_exists(Activity::class)) {
                $recentActivities = Activity::with('causer')
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
                ->get();
            $pendingEvaluations = Evaluation::where('ppp_id', $user->id)
                ->where('status', 'draf_ppp')
                ->get();
                
            return view('ppp.dashboard', compact('pendingSkts', 'pendingEvaluations'));
        } elseif ($user->isPPK()) {
            $pendingEvaluations = Evaluation::where('ppk_id', $user->id)
                ->where('status', 'draf_ppk')
                ->get();
                
            return view('ppk.dashboard', compact('pendingEvaluations'));
        } elseif ($user->isPYD()) {
            $pendingSkts = Skt::where('pyd_id', $user->id)
                ->where('status', 'draf')
                ->get();
            $pendingEvaluations = Evaluation::where('pyd_id', $user->id)
                ->where('status', 'draf_pyd')
                ->get();
                
            return view('pyd.dashboard', compact('pendingSkts', 'pendingEvaluations'));
        }
        
        return redirect('/');
    }
}