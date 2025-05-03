@extends('layouts.app')
@section('content')
<link href="{{ asset('css/member.css') }}" rel="stylesheet">

@include('layouts.sidenavbar')

<div class="main-content" id="mainContent">
    <div class="container mt-5">
    <h2>Daftar Member</h2>

    <!-- Form Search -->
    <form action="{{ route('members.view') }}" method="GET" class="mb-4">
        <div class="input-group" style="max-width: 400px;">
            <input type="text" name="search" class="form-control" placeholder="Cari nama, email, atau no telepon..." value="{{ request('search') }}">
            <div class="input-group-append">
                <button class="btn btn-primary" type="submit">Cari</button>
            </div>
        </div>
    </form>

    <!-- Table Members -->
    <div class="table-responsive">
        <table class="table table-bordered" style="background:white;">
         <thead>
    <tr>
        <th>Nama</th>
        <th>Email</th>
        <th>Telepon</th>
        <th>Membership</th>
        <th>Mulai</th>
        <th>Berakhir</th>
        <th>Aksi</th>
    </tr>
</thead>
            <tbody>
    @forelse($members as $member)
        <tr>
            <td>{{ $member->name }}</td>
            <td>{{ $member->email }}</td>
            <td>{{ $member->phone }}</td>
            <td>{{ $member->membershipType->name ?? '-' }}</td>
            <td>{{ $member->join_date ?? '-' }}</td>
            <td>{{  $member->expire_date ?? '-' }}</td>


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
            <td colspan="8" class="text-center">Tidak ada member ditemukan.</td>
        </tr>
    @endforelse
</tbody>

        </table>
    </div>
</div>
</div>

@endsection
