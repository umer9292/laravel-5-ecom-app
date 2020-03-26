<nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="{{ route('admin.dashboard') }}">Company name</a>
    <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
    <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
            <a class="nav-link" href="#">Sign out</a>
        </li>
    </ul>
</nav>


            <div class="sidebar-sticky">
                <ul class="nav flex-column mt-5">
                    <li class="nav-item mt2">
                        <a class="nav-link @if(request()->url() == route('admin.dashboard')) {{'active'}} @endif" href="{{ url('/admin/dashboard') }}">
                            <i class="fas fa-home mr-1"></i>
                            Dashboard <span class="sr-only">(current)</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-file-alt mr-1"></i>
                            Orders
                        </a>
                    </li>
                    <li class="nav-item">
                        <div class="dropdown">
                            <a
                                class="nav-link dropdown-toggle @if (request()->url() == route('admin.product.index')) {{'active'}} @endif"
                                 href="{{ route('admin.product.index') }}"
                                role="button" id="product" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                            >
                                <i class="fas fa-shopping-cart mr-1"></i>
                                Products
                            </a>
                            <div class="dropdown-menu" aria-labelledby="product">
                                <a class="dropdown-item" href="{{ route('admin.product.create') }}">Add Product</a>
                                <a class="dropdown-item" href="{{ route('admin.product.index') }}">All Products</a>
                                <a class="dropdown-item" href="{{ route('admin.product.trash') }}">Trashed Products</a>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item">
                        <div class="dropdown">
                            <a
                                class="nav-link dropdown-toggle @if(request()->url() == route('admin.category.index')) {{'active'}} @endif"
                                href="{{ route('admin.category.index') }}"
                                role="button" id="category" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                            >
                                <i class="fas fa-chart-bar mr-1"></i>
                                Categories
                            </a>
                            <div class="dropdown-menu" aria-labelledby="category">
                                <a class="dropdown-item" href="{{ route('admin.category.create') }}">Add Category</a>
                                <a class="dropdown-item" href="{{ route('admin.category.index') }}">All Categories</a>
                                <a class="dropdown-item" href="{{ route('admin.category.trash') }}">Trashed Categories</a>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item">
                        <div class="dropdown">
                            <a
                                class="nav-link dropdown-toggle @if(request()->url() == route('admin.profile.index')) {{'active'}} @endif"
                                href="{{ route('admin.profile.index') }}"
                                role="button" id="customer" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                            >
                                <i class="fas fa-users mr-1"></i>
                                Customers
                            </a>
                            <div class="dropdown-menu" aria-labelledby="customer">
                                <a class="dropdown-item" href="{{ route('admin.profile.create') }}">Add Profile</a>
                                <a class="dropdown-item" href="{{ route('admin.profile.index') }}">All Profiles</a>
                                <a class="dropdown-item" href="{{ route('admin.profile.trash') }}">Trashed Profiles</a>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-layer-group mr-1"></i>
                            Integrations
                        </a>
                    </li>
                </ul>

                <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                    <span>Saved reports</span>
                    <a class="d-flex align-items-center text-muted" href="#">
                        <span data-feather="plus-circle"></span>
                    </a>
                </h6>
                <ul class="nav flex-column mb-2">
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span data-feather="file-text"></span>
                            Current month
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span data-feather="file-text"></span>
                            Last quarter
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span data-feather="file-text"></span>
                            Social engagement
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span data-feather="file-text"></span>
                            Year-end sale
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
