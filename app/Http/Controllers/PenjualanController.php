<?php

namespace App\Http\Controllers;

use App\Models\CustomerModels;
use App\Models\DetailPenjualanModels;
use App\Models\ItemModels;
use App\Models\PenjualanModels;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller
{
    protected $menu = 'transaksi';
    protected $submenu = 'penjualan';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'menu' => $this->menu,
            'submenu' => $this->submenu,
            'label' => 'data ' . $this->submenu,
            'lists' => PenjualanModels::all()
        ];
        return view('penjualan.List')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'menu' => $this->menu,
            'submenu' => $this->submenu,
            'label' => 'tambah ' . $this->submenu,
            'customers' => CustomerModels::all(),
            'items' => ItemModels::where('stok', '>', 0)->get(),
        ];
        return view('penjualan.Add')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $registration_number = PenjualanModels::pluck('no_invoice')->last();
            $no_date = Carbon::now()->format('ymd');
            if (!$registration_number) {
                $no_invoice = "INV" . $no_date . sprintf('%04d', 1);
            } else {
                $last_number = (int)substr($registration_number, 9);
                $day = (int)substr($registration_number, 7, 2);
                $day_now = Carbon::now()->format('d');
                if ($day != $day_now) {
                    $no_invoice = "INV" . $no_date . sprintf('%04d', 1);
                } else {
                    $no_invoice = "INV" . $no_date . sprintf('%04d', $last_number + 1);
                }
            }

            if ($request->add_customer != null) {
                // insert customer
                $customer = new CustomerModels();
                $customer->nama = $request->add_customer;
                $customer->kontak = $request->add_kontak;
                $customer->alamat = $request->add_alamat;
                $customer->save();
                $insertedId = $customer->id;
            }

            // penjualan
            $penjualan = new PenjualanModels();
            $penjualan->no_invoice = $no_invoice;
            $penjualan->date = $request->date;
            if ($request->add_customer != null) {
                $penjualan->id_customer = $insertedId;
            } else {
                $penjualan->id_customer = $request->id_customer;
            }
            $penjualan->total = $request->total;
            $penjualan->total_bayar = $request->bayar_penjualan ? $request->bayar_penjualan : 0;
            $penjualan->transfer = $request->transferCheck == 'true' ? 'Y' : null;
            $penjualan->id_user = Auth::user()->id;
            $penjualan->save();
            $insertedId = $penjualan->id;

            for ($i = 0; $i < count($request->datapenjualan); $i++) {
                $produk = new DetailPenjualanModels();
                $produk->id_penjualan = $insertedId;
                $produk->id_item = $request->datapenjualan[$i]['id_item'];
                $produk->jml = $request->datapenjualan[$i]['jml'];
                // cek satuan produk
                $list_produk = ItemModels::findOrFail($request->datapenjualan[$i]['id_item']);
                $produk->id_satuan = $list_produk->id_satuan;
                $produk->harga = str_replace('.', '', $request->datapenjualan[$i]['harga']);
                $produk->save();

                // stok saat ini
                $stokin = ItemModels::where('id', $request->datapenjualan[$i]['id_item'])
                    ->whereNull('deleted_at')
                    ->sum('stok');

                // update stok
                ItemModels::where('id', $request->datapenjualan[$i]['id_item'])
                    ->update(['stok' => $stokin - (float)$request->datapenjualan[$i]['jml']]);
            }

            DB::commit();

            return response()->json([
                'code' => 200,
                'message' => 'Berhasil Input Data',
                'id' => Crypt::encryptString($insertedId)
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
            return response()->json([
                'code' => 404,
                'message' => 'Gagal Input Data',
                'id' => null
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $list = PenjualanModels::findOrFail(Crypt::decryptString($id));
        $details = DetailPenjualanModels::where('id_penjualan', Crypt::decryptString($id))->get();

        $data = [
            'menu' => $this->menu,
            'submenu' => $this->submenu,
            'label' => 'lihat ' . $this->submenu,
            'list' => $list,
            'items' => ItemModels::all(),
            'details' => $details,
            'customers' => CustomerModels::all(),
        ];

        return view('penjualan.Show')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $list = PenjualanModels::findOrFail(Crypt::decryptString($id));
        $details = DetailPenjualanModels::where('id_penjualan', Crypt::decryptString($id))->get();

        $data = [
            'menu' => $this->menu,
            'submenu' => $this->submenu,
            'label' => 'ubah ' . $this->submenu,
            'list' => $list,
            'items' => ItemModels::all(),
            'details' => $details,
            'customers' => CustomerModels::all(),
        ];

        return view('penjualan.Edit')->with($data);
    }

    public function store_edit(Request $request)
    {
        DB::beginTransaction();
        try {
            $produk = new DetailPenjualanModels();
            $produk->id_penjualan = $request->id_penjualan;
            $produk->id_item = $request->id_item;
            $produk->jml = $request->jml;
            // cek satuan produk
            $list_produk = ItemModels::findOrFail($request->id_item);
            $produk->id_satuan = $list_produk->id_satuan;
            $produk->harga = $request->harga_value;
            $produk->save();

            // stok saat ini
            $stokin = ItemModels::where('id', $request->id_item)
                ->whereNull('deleted_at')
                ->sum('stok');

            // update stok
            ItemModels::where('id', $request->id_item)
                ->update(['stok' => $stokin - $request->jml]);


            // update total penjualan
            $total_penjualan = DetailPenjualanModels::where('id_penjualan', $request->id_penjualan)
                ->whereNull('deleted_at')
                ->sum(DB::raw('harga*jml'));

            // update total
            PenjualanModels::where('id', $request->id_penjualan)
                ->update(['total' => $total_penjualan]);

            DB::commit();

            return response()->json([
                'code' => 200,
                'message' => 'Berhasil Input Data',
            ]);
        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
            // something went wrong
            return response()->json([
                'code' => 404,
                'message' => 'Gagal Input Data',
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }

    public function print($id)
    {
        $list = PenjualanModels::findOrFail(Crypt::decryptString($id));
        $details = DetailPenjualanModels::where('id_penjualan', Crypt::decryptString($id))->get();

        $data = [
            'menu' => $this->menu,
            'submenu' => $this->submenu,
            'label' => 'ubah ' . $this->submenu,
            'list' => $list,
            'items' => ItemModels::all(),
            'details' => $details,
            'customers' => CustomerModels::all(),
        ];

        return view('penjualan.print')->with($data);
    }

    public function pos($id)
    {
        $list = PenjualanModels::findOrFail(Crypt::decryptString($id));
        $details = DetailPenjualanModels::where('id_penjualan', Crypt::decryptString($id))->get();

        $data = [
            'menu' => $this->menu,
            'submenu' => $this->submenu,
            'label' => 'ubah ' . $this->submenu,
            'list' => $list,
            'items' => ItemModels::all(),
            'details' => $details,
            'customers' => CustomerModels::all(),
        ];

        return view('penjualan.pos')->with($data);
    }

    public function report()
    {
        if (isset($_GET['start']) && $_GET['end'] != '') {
            $hasil = DB::table('detail_penjualan')
                ->selectRaw('penjualan.no_invoice')
                ->selectRaw('penjualan.date')
                ->selectRaw('customer.nama as customer')
                ->selectRaw('item.nama')
                ->selectRaw('detail_penjualan.jml')
                ->selectRaw('satuan')
                ->selectRaw('detail_penjualan.harga')
                ->selectRaw('penjualan.total')
                ->selectRaw('penjualan.transfer')
                ->Join('penjualan', 'penjualan.id', 'detail_penjualan.id_penjualan')
                ->Join('item', 'item.id', 'detail_penjualan.id_item')
                ->Join('satuan', 'satuan.id', 'detail_penjualan.id_satuan')
                ->leftJoin('customer', 'customer.id', 'penjualan.id_customer')
                ->where('penjualan.date', '>=', $_GET['start'])
                ->where('penjualan.date', '<=', $_GET['end'])
                ->orderBy('penjualan.no_invoice')
                ->wherenull('penjualan.deleted_at')
                ->get();
        } else {
            $hasil = DB::table('detail_penjualan')
                ->selectRaw('penjualan.no_invoice')
                ->selectRaw('penjualan.date')
                ->selectRaw('customer.nama as customer')
                ->selectRaw('item.nama')
                ->selectRaw('detail_penjualan.jml')
                ->selectRaw('satuan')
                ->selectRaw('detail_penjualan.harga')
                ->selectRaw('penjualan.total')
                ->selectRaw('penjualan.transfer')
                ->Join('penjualan', 'penjualan.id', 'detail_penjualan.id_penjualan')
                ->Join('item', 'item.id', 'detail_penjualan.id_item')
                ->Join('satuan', 'satuan.id', 'detail_penjualan.id_satuan')
                ->leftJoin('customer', 'customer.id', 'penjualan.id_customer')
                ->wherenull('penjualan.deleted_at')
                ->where('penjualan.date', date('Y-m-d'))
                ->orderBy('penjualan.no_invoice')
                ->get();
        }

        $data = [
            'menu' => 'Rekap',
            'submenu' => $this->submenu,
            'label' => 'Rekap ' . $this->submenu,
            'lists' => $hasil
        ];
        return view('penjualan.Report')->with($data);
    }

    public function print_laporan(Request $request)
    {
        $hasil = DB::table('detail_penjualan')
            ->selectRaw('penjualan.no_invoice')
            ->selectRaw('penjualan.date')
            ->selectRaw('customer.nama as customer')
            ->selectRaw('item.nama')
            ->selectRaw('detail_penjualan.jml')
            ->selectRaw('satuan')
            ->selectRaw('detail_penjualan.harga')
            ->selectRaw('penjualan.total')
            ->selectRaw('penjualan.transfer')
            ->Join('penjualan', 'penjualan.id', 'detail_penjualan.id_penjualan')
            ->Join('item', 'item.id', 'detail_penjualan.id_item')
            ->Join('satuan', 'satuan.id', 'detail_penjualan.id_satuan')
            ->leftJoin('customer', 'customer.id', 'penjualan.id_customer')
            ->where('penjualan.date', '>=', $_GET['start'])
            ->where('penjualan.date', '<=', $_GET['end'])
            ->orderBy('penjualan.no_invoice')
            ->wherenull('penjualan.deleted_at')
            ->get();

        $data = [
            'start' => $_GET['start'],
            'end' => $_GET['end'],
            'lists' => $hasil,
        ];

        return view('penjualan.Print_report')->with($data);
    }
}
