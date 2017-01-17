<!-- Ini - Menu -->
<nav class="navbar navbar-dark bg-primary">
    <div class="container-fluid">
      <ul class="nav navbar-nav">
        <li>
          <a href="">
            <i class="glyphicon glyphicon-home"></i> Menu
          </a>
        </li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <i class="glyphicon glyphicon-user"></i> {{ strtoupper(Auth::user()->login) }}
          </a>
          <ul class="dropdown-menu">
            <li>
              <a href="">Perfil</a>
            </li>
            <li>
              <a href="">Soporte</a>
            </li>
            <li>
              <a href="">Control</a>
            </li>
            <li class="divider"></li>
            <li>
              <a href="{{ url('/logout') }}"
                  onclick="event.preventDefault();
                           document.getElementById('logout-form').submit();">
                  Salir
              </a>
              <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                  {{ csrf_field() }}
              </form>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </nav>
  <!-- Fin - Menu -->
