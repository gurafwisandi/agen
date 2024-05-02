<?php

namespace App\Http\Controllers;

use App\Helper\AlertHelper;
use App\Models\DetailPenjualanModels;
use App\Models\ItemModels;
use App\Models\PenjualanModels;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class DetailPenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $decrypted_id = Crypt::decryptString($id);
            $save = DetailPenjualanModels::findOrFail($decrypted_id);
            $jml = $save->jml;
            $id_penjualan = $save->id_penjualan;
            $id_item = $save->id_item;
            $save->delete();

            // stok saat ini
            $stokin = ItemModels::where('id', $id_item)
                ->whereNull('deleted_at')
                ->sum('stok');

            // update stok
            ItemModels::where('id', $id_item)
                ->update(['stok' => $stokin + $jml]);


            // update total penjualan
            $total_penjualan = DetailPenjualanModels::where('id_penjualan', $id_penjualan)
                ->whereNull('deleted_at')
                ->sum(DB::raw('harga*jml'));

            // update total
            PenjualanModels::where('id', $id_penjualan)
                ->update(['total' => $total_penjualan]);

            DB::commit();
            AlertHelper::deleteAlert(true);
            return back();
        } catch (\Throwable $err) {
            DB::rollBack();
            AlertHelper::deleteAlert(false);
            return back();
        }
    }
}
