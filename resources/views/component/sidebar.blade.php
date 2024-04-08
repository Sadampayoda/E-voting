<nav id="sidebar" class="active bg-warning">
    <p class="text-center fs-4"><img src="" class="logo">E-Voting</p>
    <ul class="list-unstyled components mb-5">
        @if (auth()->user()->role == 'admin')
            <li class="active">
                <a href="{{route('beranda.admin')}}"><span class="bi bi-alarm-fill pe-2"></span>Dashboard</a>
            </li>
            <li>
                <a href="{{route('santri.index')}}"><span class=" fa fa-user"></span> Data BEM</a>
            </li>
            <li>
                <a href="{{route('kegiatan.index')}}"><span class="bi bi-bar-chart-line"></span> Kegiatan</a>
            </li>
            <li>
                <a href="{{route('user-manejement.index')}}"><span class="fa fa-user"></span> User Manajement</a>
            </li>
            
        @endif
        <li>
            <a href="{{route('beranda.profile')}}"><span class="bi bi-person"></span> Profile</a>
        </li>
       
        <li>
            <a href="{{route('beranda.logout')}}"><span class="bi bi-box-arrow-right"></span>Logout</a>
        </li>
    </ul>

    
</nav>




    
