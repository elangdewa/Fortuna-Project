<form action="{{ route('memberships.store') }}" method="POST">
    @csrf

    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

    <div class="form-group">
        <label for="membership_type">Jenis Membership</label>
        <select name="membership_type" id="membership_type" class="form-control" required>
            @foreach ($types as $type)
                <option value="{{ $type->id }}">{{ $type->name }}</option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-primary mt-3">Daftar Membership</button>
</form>
