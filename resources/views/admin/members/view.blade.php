@extends('layouts.admin')

@section('admin-content')
<link href="{{ asset('css/member.css') }}" rel="stylesheet">

<div class="main-content" id="mainContent">
    <div class="container mt-5">
    <h2>Daftar Member</h2>

    <!-- Form Search -->
    <div class="d-flex justify-content-end mb-4">
        <form action="{{ route('members.view') }}" method="GET" style="max-width: 400px;" class="w-100">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Cari nama, email, atau no telepon..." value="{{ request('search') }}">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">Cari</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Table Members -->
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Foto</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Telepon</th>
                    <th>Alamat</th>
                    <th>Membership</th>
                    <th>Status</th>
                    <th>Mulai</th>
                    <th>Berakhir</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($members as $member)
                    <tr>
                        <td class="text-center">
                            <div class="profile-container">
                                @if($member->profile_photo)
                                    <img src="{{ asset('storage/profile_photos/' . $member->profile_photo) }}"
                                         alt="{{ $member->name }}"
                                         class="profile-image">
                                @else
                                    <div class="profile-initial">{{ strtoupper(substr($member->name, 0, 1)) }}</div>
                                @endif
                            </div>
                        </td>
                        <td>{{ $member->name }}</td>
                        <td>{{ $member->email }}</td>
                        <td>{{ $member->phone }}</td>
                        <td>{{ $member->address }}</td>
                        <td>{{ $member->membership->type->name ?? '-' }}</td>
                        <td>
                            <span class="badge
                                @if($member->membership->status == 'active') bg-success
                                @elseif($member->membership->status == 'expired') bg-danger
                                @else bg-warning @endif">
                                {{ $member->membership->status ?? 'inactive' }}
                            </span>
                        </td>
                        <td>{{ $member->membership->start_date ? \Carbon\Carbon::parse($member->membership->start_date)->format('d M Y') : '-' }}</td>
                        <td>{{ $member->membership->end_date ? \Carbon\Carbon::parse($member->membership->end_date)->format('d M Y') : '-' }}</td>
                        <td>
                            <a href="{{ route('admin.members.edit', $member->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('admin.members.destroy', $member->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center">Tidak ada member ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if(isset($members) && method_exists($members, 'links'))
        <div class="d-flex justify-content-center mt-4">
            {{ $members->links() }}
        </div>
    @endif
</div>
</div>
