<div class="sidebar">
    <div class="sidebar-header">
        <h3>Fortuna Gym</h3>
    </div>

    <ul class="nav flex-column">
        <li class="nav-item">
            <a href="{{ route('superadmin.dashboard') }}" class="nav-link">Dashboard</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('superadmin.admins.index') }}" class="nav-link">Admin Management</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('superadmin.fitness.index') }}" class="nav-link">Fitness</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('superadmin.trainers.index') }}" class="nav-link">Trainer</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('superadmin.members.index') }}" class="nav-link">Member Management</a>
        <li class="nav-item">
            <a href="{{ route('superadmin.settings.index') }}" class="nav-link">Settings</a>
        </li>

    </ul>
</div>
