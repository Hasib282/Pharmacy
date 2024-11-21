<header>
    <div class="company-details">
        <div class="company-logo">
            <img src="/images/male.png" alt="">
        </div>
        <div class="company-name">
            <strong>Team-Pharma</strong>
        </div>
        
    </div>
    @if (session('message'))
        <h6 style="text-align:center; margin-top:5px; color:#dc3545;">
            {{ session('message') }}
        </h6>
    @endif
    
    <!-- Navbar -->
    <div class="navbar-menu">
        @include('layouts.navbar')
    </div>
</header>