<div id="sidebar-menu">
    <!-- Left Menu Start -->
    <ul class="metismenu list-unstyled" id="side-menu">
        <li>
            <a href="{{ route('dashboard') }}" class="waves-effect">
                <i class="bx bx-home-alt"></i>
                <span key="t-dashboards">DASHBOARD</span>
            </a>
        </li>
        <li <?php
        if (Request::segment(1) == 'user' or Request::segment(1) == 'cabang' or Request::segment(1) == 'satuan' or Request::segment(1) == 'item') {
            echo ' class="mm-active"';
        } else {
            echo ' class=""';
        }
        ?>>
            <a href="javascript: void(0);" <?php
            if (Request::segment(1) == 'user' or Request::segment(1) == 'cabang' or Request::segment(1) == 'satuan' or Request::segment(1) == 'item') {
                echo ' class="has-arrow waves-effect mm-active" aria-expanded="true"';
            } else {
                echo ' class="has-arrow waves-effect"';
            }
            ?>>
                <i class="bx bx bxs-data"></i>
                <span key="t-invoices">Master</span>
            </a>
            <ul class="" <?php
            if (Request::segment(1) == 'user' or Request::segment(1) == 'cabang' or Request::segment(1) == 'satuan' or Request::segment(1) == 'item') {
                echo ' class="sub-menu mm-collapse mm-show" aria-expanded="false"';
            } else {
                echo ' class="sub-menu mm-collapse" aria-expanded="true"';
            }
            ?>>
                <li <?php
                if (Request::segment(1) == 'cabang') {
                    echo ' class="mm-active"';
                } else {
                    echo ' class=""';
                }
                ?>>
                    <a href="{{ route('cabang.index') }}">Cabang</a>
                </li>
                <li <?php
                if (Request::segment(1) == 'user') {
                    echo ' class="mm-active"';
                } else {
                    echo ' class=""';
                }
                ?>>
                    <a href="{{ route('user.list') }}">User</a>
                </li>
                <li <?php
                if (Request::segment(1) == 'satuan') {
                    echo ' class="mm-active"';
                } else {
                    echo ' class=""';
                }
                ?>>
                    <a href="{{ route('satuan.index') }}">Satuan</a>
                </li>
                <li><a href="{{ route('customer.index') }}">Customer</a></li>
                <li><a href="{{ route('item.index') }}">Item</a></li>
            </ul>
        </li>

        <li>
            <a href="{{ route('pembelian.index') }}" class="waves-effect">
                <i class="bx bxs-truck"></i>
                <span key="t-dashboards">Pembelian</span>
            </a>
        </li>
        <li>
            <a href="{{ route('penjualan.index') }}" class="waves-effect">
                <i class="bx bx-shopping-bag"></i>
                <span key="t-dashboards">Penjualan</span>
            </a>
        </li>
        <li>
            <a href="{{ route('penjualan.report') }}" class="waves-effect">
                <i class="bx bx-package"></i>
                <span key="t-dashboards">Report</span>
            </a>
        </li>
    </ul>
</div>
