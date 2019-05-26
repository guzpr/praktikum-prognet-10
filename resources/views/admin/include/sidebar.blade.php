<body class="animsition">
        <div class="page-wrapper">
            <!-- MENU SIDEBAR-->
            <aside class="menu-sidebar d-none d-lg-block">
                <div class="logo">
                    <a href="/admin">
                        <img src="/adminResource/images/icon/logo.png" alt="Cool Admin" />
                    </a>
                </div>
                <div class="menu-sidebar__content js-scrollbar1">
                    <nav class="navbar-sidebar">
                        <ul class="list-unstyled navbar__list">
                            <li >
                                <a href=" {{route('admin.product')}} ">
                                    <i class="fas fa-chart-bar"></i>Product</a>
                            </li>
                            <li >
                                <a href="{{route('admin.categories')}} ">
                                    <i class="fas fa-table"></i>Product Category</a>
                            </li>
                            <li >
                                <a href="{{route('admin.discount')}}">
                                    <i class="far fa-check-square"></i>Discount</a>
                            </li>
                            <li > 
                                <a href="{{route('admin.courier')}}">
                                    <i class="fas fa-calendar-alt"></i>Courier</a>
                            </li>
                            <li >
                                <a href="{{route('admin.transaction')}}">
                                    <i class="fas fa-shopping-cart"></i>Transaction</a>
                            </li>
                            <li >
                                <a href="{{route('admin.response')}}">
                                    <i class="fas fa-comment"></i>Response</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </aside>
    