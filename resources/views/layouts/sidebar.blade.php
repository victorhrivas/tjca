<aside class="main-sidebar elevation-4"> <!-- quitado sidebar-dark-primary -->
    <a href="{{ route('home') }}" class="brand-link d-flex align-items-center">
        <img src="{{ url('/') }}/images/logo.png" class="brand-image" alt="TJCA Logo" style="height:55px;width:auto;margin-right:8px;">
        <span class="brand-text text-uppercase font-weight-bold">{{ config('app.name') }}</span>
    </a>


    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column"
                data-widget="treeview" role="menu" data-accordion="false">
                @include('layouts.menu')
            </ul>
        </nav>
    </div>
</aside>
