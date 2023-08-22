@php
    $menu = DB::table('ms_menu')
        // ->leftJoin('ms_submenu','menu_id','=','ms_menu.id')
        ->where('userlevel', Session::get('login')[0]->level)
        ->orderBy('indexmenu','ASC')
        // ->orderBy('indexsubmenu','ASC')
        ->get();
    // dd($menu);
@endphp
<div class="sidebar-wrap  sidebar-pushcontent">
    <!-- Add overlay or fullmenu instead overlay -->
    <div class="closemenu text-muted">Close Menu</div>
    <div class="sidebar dark-bg">
        <!-- user information -->
        <div class="row my-3">
            <div class="col-12 ">
                <div class="card shadow-sm bg-opac text-white border-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-auto">
                                <figure class="avatar avatar-44 rounded-15">
                                    <img src="https://cdn-icons-png.flaticon.com/512/3237/3237472.png" alt="">
                                </figure>
                            </div>
                            <div class="col px-0 align-self-center">
                                <p class="mb-1">{{ Session::get('login')[0]->username }}</p>
                                <p class="text-muted size-12">{{ Session::get('login')[0]->level }}</p>
                            </div>
                            <div class="col-auto">
                                <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="btn btn-44 btn-light">
                                    <i class="bi bi-box-arrow-right"></i>
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php
                        $userid = Session::get('login')[0]->level;
                        $drealisasi = DB::select("SELECT count(1)  as realisasi FROM tr_sppa WHERE createby='$userid' and status in (3,20) ");
                        // dump($drealisasi);
                    ?>
                    {{-- <div class="card bg-opac text-white border-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <h1 class="display-4">{{ $drealisasi[0]->realisasi }}</h1>
                                </div>
                                <div class="col-auto">
                                    <p class="text-muted">Realisasi</p>
                                </div>
                                <div class="col text-end">
                                    <p class="text-muted"><a href="addmoney.html" >+ Top up</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
        <!-- user emnu navigation -->
        <div class="row">
            <div class="col-12">
                <ul class="nav nav-pills">
                    <li class="nav-item">
                        <a class="nav-link {{ $route == 'index' ? 'active' : '' }}" aria-current="page" href="{{ url('index') }}">
                            <div class="avatar avatar-40 rounded icon"><i class="bi bi-house-door"></i></div>
                            <div class="col">Home</div>
                            <div class="arrow"><i class="bi bi-chevron-right"></i></div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $route == 'profile' ? 'active' : '' }}" href="{{ url('profile')}}" tabindex="-1">
                            <div class="avatar avatar-40 rounded icon"><i class="bi bi-palette"></i></div>
                            <div class="col">Profile</div>
                            <div class="arrow"><i class="bi bi-chevron-right"></i></div>
                        </a>
                    </li>
                    <?php
                        foreach ($menu as $m) {
                    ?>
                            @if (empty($m->module))
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
                                        aria-expanded="false">
                                        <div class="avatar avatar-40 rounded icon"><i class="{{ $m->bicon }}"></i></div>
                                        <div class="col">{{ $m->menu_utama }}</div>
                                        <div class="arrow"><i class="bi bi-plus plus"></i> <i class="bi bi-dash minus"></i>
                                        </div>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <?php
                                            $submenu = DB::table('ms_submenu')
                                                ->where('menu_id', $m->id)
                                                ->where('visible', 1)
                                                ->orderBy('indexsubmenu','ASC')
                                                ->get();
                                            
                                            foreach ($submenu as $sm) {
                                        ?>
                                                <li>
                                                    <a class="dropdown-item nav-link {{ $route == $sm->submenulink ? 'active' : '' }}" href="{{ url($sm->submenulink) }}">
                                                        <div class="avatar avatar-40 rounded icon">
                                                            <i class="{{ $sm->bicon }}"></i>
                                                        </div>
                                                        <div class="col">{{ $sm->submenu }}</div>
                                                        <div class="arrow">
                                                            <i class="bi bi-chevron-right"></i>
                                                        </div>
                                                    </a>
                                                </li>
                                        <?php
                                            }
                                        ?>
                                    </ul>
                                </li>
                            @else
                                <li class="nav-item">
                                    <a class="nav-link {{ $route == $m->module ? 'active' : '' }}" href="{{ url($m->module)}}" tabindex="-1">
                                        <div class="avatar avatar-40 rounded icon"><i class="{{ $m->bicon }}"></i></div>
                                        <div class="col">{{ $m->menu_utama }}</div>
                                        <div class="arrow"><i class="bi bi-chevron-right"></i></div>
                                    </a>
                                </li>
                            @endif
                    <?php
                        }
                    ?>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" tabindex="-1">
                            <div class="avatar avatar-40 rounded icon"><i class="bi bi-box-arrow-right"></i></div>
                            <div class="col">Logout</div>
                            <div class="arrow"><i class="bi bi-chevron-right"></i></div>
                        </a>
                    </li>
                    <script>
                        $(document).ready(function(){
                            $('.dropdown-item.nav-link.active').parent().parent().addClass('show');
                            $('.dropdown-item.nav-link.active').parent().parent().prev('a').addClass('show');
                        });
                    </script>
                </ul>
            </div>
        </div>
    </div>
</div>