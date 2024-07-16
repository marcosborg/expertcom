<nav id="navbar" class="navbar">
    <ul>
        <li><a class="nav-link active" href="{{ request()->is('/') ? '#hero' : '/' }}">Início</a></li>
        <li><a class="nav-link" href="{{ request()->is('/') ? '#about' : '/#about' }}">Quem somos</a></li>
        <li><a class="nav-link" href="{{ request()->is('/') ? '#contact' : '/#contact' }}">Contactos</a></li>
        <li><a class="nav-link" href="{{ request()->is('/') ? '#services' : '/#services' }}">Trabalhe connosco</a></li>
        @auth
        <li><a class="getstarted" href="/admin">Dashboard</a></li>
        @else
        <li><a class="getstarted" href="/login">Login</a></li>
        @endauth
    </ul>
    <i class="bi bi-list mobile-nav-toggle"></i>
</nav><!-- .navbar -->