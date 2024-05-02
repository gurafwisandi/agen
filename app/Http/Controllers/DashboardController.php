<?php

namespace App\Http\Controllers;

use App\Models\PembelianModels;
use App\Models\Pengumuman;
use App\Models\PenjualanModels;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $menu = 'dashboard';

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = [
            'menu' => $this->menu,
            'submenu' => 'dashboard',
            'label' => 'data agama',
            'pembelian' => PembelianModels::where('date', date('Y-m-d'))->count(),
            'penjualan' => PenjualanModels::where('date', date('Y-m-d'))->count()
        ];
        return view('dashboard')->with($data);
    }
}
