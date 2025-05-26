<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PydGroup;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $groups = PydGroup::all();
        return view('admin.users.create', compact('groups'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'peranan' => 'required|in:super_admin,admin,ppp,ppk,pyd',
            'jawatan' => 'nullable|string|max:255',
            'gred' => 'nullable|string|max:255',
            'kementerian_jabatan' => 'nullable|string|max:255',
            'pyd_group_id' => 'nullable|exists:pyd_groups,id',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'peranan' => $request->peranan,
            'jawatan' => $request->jawatan,
            'gred' => $request->gred,
            'kementerian_jabatan' => $request->kementerian_jabatan,
            'pyd_group_id' => $request->pyd_group_id,
        ]);

        return redirect()->route('users.index')
            ->with('success', 'Pengguna berjaya dicipta.');
    }

    public function show(User $user)
    {
        $ppps = User::where('peranan', 'ppp')->get();
        $ppks = User::where('peranan', 'ppk')->get();

        return view('admin.users.show', compact('user', 'ppps', 'ppks'));
    }

    public function edit(User $user)
    {
        $groups = PydGroup::all();
        return view('admin.users.edit', compact('user', 'groups'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'peranan' => 'required|in:super_admin,admin,ppp,ppk,pyd',
            'jawatan' => 'nullable|string|max:255',
            'gred' => 'nullable|string|max:255',
            'kementerian_jabatan' => 'nullable|string|max:255',
            'pyd_group_id' => 'nullable|exists:pyd_groups,id',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'peranan' => $request->peranan,
            'jawatan' => $request->jawatan,
            'gred' => $request->gred,
            'kementerian_jabatan' => $request->kementerian_jabatan,
            'pyd_group_id' => $request->pyd_group_id,
        ];

        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        return redirect()->route('users.index')
            ->with('success', 'Pengguna berjaya dikemaskini.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')
            ->with('success', 'Pengguna berjaya dipadam.');
    }

    public function assignEvaluators(Request $request, User $pyd)
    {
        $request->validate([
            'ppp_id' => 'required|exists:users,id',
            'ppk_id' => 'required|exists:users,id',
        ]);

        $pyd->update([
            'ppp_id' => $request->ppp_id,
            'ppk_id' => $request->ppk_id,
        ]);

        return redirect()->route('users.index')
            ->with('success', 'Penilai berjaya ditetapkan.');
    }
}