<nav id="navbar" class="navbar">
    <ul>
        <li><a class="nav-link active" href="{{ request()->is('/') ? '#hero' : '/' }}">Início</a></li>
        <li class="dropdown"><a href="#"><span>A empresa</span> <i class="bi bi-chevron-down"></i></a>
            <ul>
                <li><a href="/cms/4/quem-somos">Quem somos</a></li>
                <li><a href="/cms/5/o-nosso-compromisso">O nosso compromisso</a></li>
                <li><a href="/cms/6/carreiras"">Carreiras</a></li>
                <li><a href="#">Parceiros</a></li>
                <li><a href="#">Contatos</a></li>
            </ul>
        </li>
        <li class="dropdown"><a href="#"><span>TVDE</span> <i class="bi bi-chevron-down"></i></a>
            <ul>
                <li><a href="#">Trabalhar com Viatura Própria</a></li>
                <li><a href="#">Motorista TVDE</a></li>
                <li><a href="#">Programa de Apoio Motoristas</a></li>
                <li><a href="#">Consultoria a Empresa TVDE</a></li>
                <li><a href="#">Aluguer Viaturas</a></li>
                <li><a href="#">Formação </a></li>
            </ul>
        </li>
        <li><a class="nav-link" href="">Stand</a></li>
        <li><a class="nav-link" href="">Transfers e Tours</a></li>
        @auth
        <li><a class="getstarted" href="/admin">Dashboard</a></li>
        @else
        <li><a class="getstarted" href="/login">Login</a></li>
        @endauth
    </ul>
    <i class="bi bi-list mobile-nav-toggle"></i>
</nav><!-- .navbar -->