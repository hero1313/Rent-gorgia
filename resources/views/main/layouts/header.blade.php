<div class="header">

    <!-- Logo -->
    <div class="header-left">
        <img class="logo-gorgia" src="../assets/image/gorgia.png" />
    </div>
    <!-- /Logo -->

    <a id="mobile_btn" style="height:70px" class="mobile_btn" href="#sidebar"><i class="fa fa-bars"></i></a>

    <!-- Header Menu -->
    <ul class="nav user-menu">

        <li class="nav-item dropdown has-arrow main-drop">
            <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="/login">შესვლა</a>
            </div>
        </li>
    </ul>
    <!-- /Header Menu -->

    <!-- Mobile Menu -->
    <div class="dropdown mobile-user-menu">
        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
        <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item" href="login.html">გასვლა</a>
        </div>
    </div>
    <!-- /Mobile Menu -->

</div>
<!-- /Header -->

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="active " id="add">
                    <a href="#"><i class="la la-ticket"></i> <span>ფილტრი</span></a>
                </li>

                <li class="active hide-li add_li">
                    <a href="{{ route('index.branch')}}"><i class="la la-ticket"></i> <span>ფილიალი/ადგილი</span></a>
                </li>
                <li class="active hide-li add_li">
                    <a href="{{ route('index.type')}}"><i class="la la-ticket"></i> <span>ტიპი</span></a>
                </li>
                <li class="active hide-li add_li">
                    <a href="{{ route('index.material')}}"><i class="la la-ticket"></i> <span>მასალა</span></a>
                </li>
                <li class="active hide-li add_li">
                    <a href="{{ route('index.section')}}"><i class="la la-ticket"></i> <span>სექცია</span></a>
                </li>

                <li class="active" id="ijara">
                    <a href="#"><i class="la la-ticket"></i> <span>იჯარა</span></a>
                </li>
                <li class="active hide-li ijara_li">
                    <a href="{{ route('index.own-banner')}}"><i class="la la-ticket"></i> <span>გორგიას ბანერები</span></a>
                </li>
                <li class="active hide-li ijara_li">
                    <a href="{{ route('index.outdoor-banner')}}"><i class="la la-ticket"></i> <span>ნაქირავები ბანერები</span></a>
                </li>
                <li class="active hide-li ijara_li ">
                    <a href="{{ route('index.party')}}"><i class="la la-ticket"></i> <span>ფართები</span></a>
                </li>

                <li class="active" id="report">
                    <a href="#"><i class="la la-ticket"></i> <span>რეპორტი</span></a>
                </li>
                <li class="active hide-li report_li">
                    <a href="{{ route('report.own')}}"><i class="la la-ticket"></i> <span>ბანერების მოიჯარეები</span></a>
                </li>
                <li class="active hide-li report_li">
                    <a href="{{ route('report.party')}}"><i class="la la-ticket"></i> <span>ფართების მოიჯარეები</span></a>
                </li>

                <li class="active hide-li report_li">
                    <a href="{{ route('report.outdoor')}}"><i class="la la-ticket"></i> <span> ნაქირავები ბანერები</span></a>
                </li>
                @if (Auth::user())
                <li class="active ">
                    <a href="/logout"><i class="la la-ticket"></i> <span> გასვლა</span></a>
                </li>
                @else
                <li class="active ">
                    <a href="/login"><i class="la la-ticket"></i> <span>შესვლა</span></a>
                </li>
                @endif

            </ul>
        </div>
    </div>
</div>
<script>
    $("#report").click(function() {
        $(".report_li").toggle()
    });
    $("#ijara").click(function() {
        $(".ijara_li").toggle()
    });
    $("#add").click(function() {
        $(".add_li").toggle()
    });
</script>
<!-- /Sidebar -->