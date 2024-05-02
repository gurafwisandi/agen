<?php

namespace App\Http\Controllers;

use App\Helper\AlertHelper;
use App\Models\DetailPembelianModels;
use App\Models\ItemModels;
use App\Models\PembelianModels;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class PembelianController extends Controller
{
    protected $menu = 'transaksi';
    protected $submenu = 'Pembelian';

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
            'lists' => PembelianModels::all()
        ];
        return view('pembelian.List')->with($data);
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
            'items' => ItemModels::all(),
        ];
        return view('pembelian.Add')->with($data);
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
            $registration_number = PembelianModels::pluck('no_invoice')->last();
            $no_date = Carbon::now()->format('ymd');
            if (!$registration_number) {
                $no_invoice = "BEL" . $no_date . sprintf('%08d', 1);
            } else {
                $last_number = (int)substr($registration_number, 9);
                $moon = (int)substr($registration_number, 5, 2);
                $moon_now = Carbon::now()->format('m');
                if ($moon != $moon_now) {
                    $no_invoice = "BEL" . $no_date . sprintf('%08d', 1);
                } else {
                    $no_invoice = "BEL" . $no_date . sprintf('%08d', $last_number + 1);
                }
            }

            $pembelian = new PembelianModels();
            $pembelian->no_invoice = $no_invoice;
            $pembelian->date = $request->tanggal;
            $pembelian->keterangan = $request->keterangan;
            $pembelian->save();
            $insertedId = $pembelian->id;

            for ($i = 0; $i < count($request->datapembelian); $i++) {
                $produk = new DetailPembelianModels();
                $produk->id_pembelian = $insertedId;
                $produk->id_item = $request->datapembelian[$i]['id_item'];
                $produk->jml = $request->datapembelian[$i]['jumlah'];
                $produk->save();

                // stok saat ini
                $stokin = ItemModels::where('id', $request->datapembelian[$i]['id_item'])
                    ->whereNull('deleted_at')
                    ->sum('stok');

                // update stok
                ItemModels::where('id', $request->datapembelian[$i]['id_item'])
                    ->update(['stok' => $stokin + $request->datapembelian[$i]['jumlah']]);
            }

            DB::commit();

            return response()->json([
                'code' => 200,
                'message' => 'Berhasil Input Data',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
            return response()->json([
                'code' => 404,
                'message' => 'Gagal Input Data',
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
        $list = PembelianModels::findOrFail(Crypt::decryptString($id));
        $details = DetailPembelianModels::where('id_pembelian', Crypt::decryptString($id))->get();

        $data = [
            'menu' => $this->menu,
            'submenu' => $this->submenu,
            'label' => 'lihat ' . $this->submenu,
            'list' => $list,
            'items' => ItemModels::all(),
            'details' => $details,
        ];

        return view('pembelian.Show')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $list = PembelianModels::findOrFail(Crypt::decryptString($id));
        $details = DetailPembelianModels::where('id_pembelian', Crypt::decryptString($id))->get();

        $data = [
            'menu' => $this->menu,
            'submenu' => $this->submenu,
            'label' => 'ubah ' . $this->submenu,
            'list' => $list,
            'items' => ItemModels::all(),
            'details' => $details,
        ];

        return view('pembelian.Edit')->with($data);
    }

    public function store_edit(Request $request)
    {
        DB::beginTransaction();
        try {
            $produk = new DetailPembelianModels();
            $produk->id_pembelian = $request->id_pembelian;
            $produk->id_item = $request->id_item;
            $produk->jml = $request->jml;
            $produk->save();

            // stok saat ini
            $stokin = ItemModels::where('id', $request->id_item)
                ->whereNull('deleted_at')
                ->sum('stok');

            // update stok
            ItemModels::where('id', $request->id_item)
                ->update(['stok' => $stokin + $request->jml]);

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
        // DB::beginTransaction();
        // try {
        //     $decrypted_id = Crypt::decryptString($id);
        //     $save = PembelianModels::findOrFail($decrypted_id);
        //     $save->nama = $request->pembelian;
        //     $save->keterangan = $request->keterangan;
        //     $save->id_satuan = $request->id_satuan;
        //     $save->save();

        //     DB::commit();
        //     AlertHelper::updateAlert(true);
        //     return redirect('pembelian');
        // } catch (\Throwable $err) {
        //     DB::rollBack();
        //     AlertHelper::updateAlert(false);
        //     return back();
        // }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // DB::beginTransaction();
        // try {
        //     $decrypted_id = Crypt::decryptString($id);
        //     $save = PembelianModels::findOrFail($decrypted_id);
        //     $save->delete();

        //     DB::commit();
        //     AlertHelper::deleteAlert(true);
        //     return redirect('pembelian');
        // } catch (\Throwable $err) {
        //     DB::rollBack();
        //     AlertHelper::deleteAlert(false);
        //     return back();
        // }
    }
}
