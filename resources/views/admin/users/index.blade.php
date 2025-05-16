@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2 class="fw-bold">Senarai Pengguna</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('users.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Tambah Pengguna
            </a>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Nama</th>
                            <th>Emel</th>
                            <th>Peranan</th>
                            <th>Jawatan</th>
                            <th>Status</th>
                            <th>Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @switch($user->peranan)
                                    @case('super_admin')
                                        <span class="badge bg-danger">Super Admin</span>
                                        @break
                                    @case('admin')
                                        <span class="badge bg-primary">Admin</span>
                                        @break
                                    @case('ppp')
                                        <span class="badge bg-info">PPP</span>
                                        @break
                                    @case('ppk')
                                        <span class="badge bg-warning text-dark">PPK</span>
                                        @break
                                    @case('pyd')
                                        <span class="badge bg-success">PYD</span>
                                        @break
                                @endswitch
                            </td>
                            <td>{{ $user->jawatan ?? '-' }}</td>
                            <td>
                                @if($user->email_verified_at)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Tidak Aktif</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('users.show', $user) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @can('delete', $user)
                                <form action="{{ route('users.destroy', $user) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Adakah anda pasti?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @endcan
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Tiada pengguna dijumpai.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($users->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $users->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection