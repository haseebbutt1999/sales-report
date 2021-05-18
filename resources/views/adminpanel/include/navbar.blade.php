<body>
{{--Nav Bar Start--}}
{{--<nav class="navbar bg-primary-dark navbar-expand p-0">--}}
{{--    <a class="navbar-brand text-center col-xs-12 col-md-3 col-lg-2 mr-0" href="/">--}}
{{--        <img src="{{asset('polished_asset/assets/polished-logo-small.png')}}" alt="logo" width="42px">--}}
{{--        Custom Checkout</a>--}}
{{--    <button class="btn btn-link d-block d-md-none" data-toggle="collapse" data-target="#sidebar-nav" role="button">--}}
{{--        <span class="oi oi-menu"></span>--}}
{{--    </button>--}}

{{--    <input class="border-dark bg-primary-darkest form-control d-none d-md-block w-50 ml-3 mr-2" type="text"--}}
{{--           placeholder="Search" aria-label="Search">--}}
{{--</nav>--}}

<nav class="navbar navbar-expand-lg " style="background: #202e78;">
    <a  style="margin-left: 10px;" class="navbar-brand" href="{{route('dashboard')}}">Sales Report</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <div class="text-center">
            <ul class="custom-ul navbar-nav mr-auto text-center">
                <li class="nav-item active">
                    <a class="nav-link" href="{{Route('dashboard')}}">Dashboard<span class="sr-only"></span></a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="{{Route('reports')}}">Saved Reports<span class="sr-only"></span></a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="{{Route('settings')}}">Settings<span class="sr-only"></span></a>
                </li>
            </ul>
        </div>
    </div>
    <div >
        <div class="  nav-item dropdown bg-white" style="border-radius: 5px;">
            <a class="nav-link dropdown-toggle" style="padding: 0.2rem 0.8rem !important;" href="javascript:;" id="navbar-primary_dropdown_1" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Sync Actions</a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbar-primary_dropdown_1">
                <a class="dropdown-item" href="{{route('collection-sync')}}">Sync Collections</a>
                <a class="dropdown-item" href="{{route('product-sync')}}">Sync Products</a>
                <a class="dropdown-item" href="{{route('order-sync')}}">Sync Orders</a>
            </div>
        </div>
    </div>
</nav>


{{--Nav Bar End--}}
