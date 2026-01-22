<nav class="nav navbar navbar-expand-lg navbar-light iq-navbar mb-3">
    <div class="container-fluid navbar-inner">
       
        <button class="btn btn-outline-primary btn-sm d-xl-none me-2"  data-toggle="sidebar" aria-label="Toggle Sidebar">
            <i class="fa-solid fa-bars"></i>
        </button>

         
            <!-- Left Side Of Navbar -->
          

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ms-md-auto">
                <!-- Authentication Links -->
                @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                    @endif

                  
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button"
                            data-bs-toggle="dropdown"  aria-expanded="false" >
                            <i class="fa-solid fa-user me-2"></i>
                            {{ Auth::user()->name }}
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                             <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                <i class="fa-solid fa-right-from-bracket me-2"></i>
                                {{ __('Logout') }}
                            </a>
                                
                            </li>
                           

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </ul>
                    </li>
                @endguest
            </ul>
        </div>
</nav>

