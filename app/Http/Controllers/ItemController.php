<?php

namespace App\Http\Controllers;

use App\Helper\AlertHelper;
use App\Models\HargaModels;
use App\Models\ItemModels;
use App\Models\SatuanModels;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    protected $menu = 'master';
    protected $submenu = 'item';

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
            'lists' => ItemModels::all()
        ];
        return view('item.List')->with($data);
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
            'satuan' => SatuanModels::all(),
        ];
        return view('item.Add')->with($data);
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
            $save = new ItemModels();
            $save->nama = $request->item;
            $save->keterangan = $request->keterangan;
            $save->id_satuan = $request->id_satuan;
            $save->save();

            DB::commit();
            AlertHelper::addAlert(true);
            return redirect('item');
        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
            // something went wrong
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
        $list = ItemModels::findOrFail(Crypt::decryptString($id));

        $data = [
            'menu' => $this->menu,
            'submenu' => $this->submenu,
            'label' => 'data ' . $this->submenu,
            'list' => $list,
            'satuan' => SatuanModels::all(),
            'harga' => HargaModels::where('id_item', Crypt::decryptString($id))->get(),
        ];

        return view('item.Show')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $list = ItemModels::findOrFail(Crypt::decryptString($id));

        $data = [
            'menu' => $this->menu,
            'submenu' => $this->submenu,
            'label' => 'ubah ' . $this->submenu,
            'list' => $list,
            'satuan' => SatuanModels::all(),
        ];

        return view('item.Edit')->with($data);
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
        DB::beginTransaction();
        try {
            $decrypted_id = Crypt::decryptString($id);
            $save = ItemModels::findOrFail($decrypted_id);
            $save->nama = $request->item;
            $save->keterangan = $request->keterangan;
            $save->id_satuan = $request->id_satuan;
            $save->save();

            DB::commit();
            AlertHelper::updateAlert(true);
            return redirect('item');
        } catch (\Throwable $err) {
            DB::rollBack();
            AlertHelper::updateAlert(false);
            return back();
        }
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
            $save = ItemModels::findOrFail($decrypted_id);
            $save->delete();

            DB::commit();
            AlertHelper::deleteAlert(true);
            return redirect('item');
        } catch (\Throwable $err) {
            DB::rollBack();
            AlertHelper::deleteAlert(false);
            return back();
        }
    }

    public function store_price(Request $request)
    {
        DB::beginTransaction();
        try {
            $save = new HargaModels();
            $save->id_item = $request->id_item;
            $save->jml = $request->jml;
            $save->harga = $request->harga;
            $save->save();

            DB::commit();
            AlertHelper::addAlert(true);

            $Id = Crypt::encryptString($request->id_item);
            return redirect('item/' . $Id);
        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
            // something went wrong
        }
    }

    public function destroy_price($id)
    {
        DB::beginTransaction();
        try {
            $decrypted_id = Crypt::decryptString($id);
            $save = HargaModels::findOrFail($decrypted_id);
            $save->delete();

            DB::commit();
            AlertHelper::deleteAlert(true);
            return back();
        } catch (\Throwable $err) {
            DB::rollBack();
            AlertHelper::deleteAlert(false);
            return back();
        }
    }

    public function dropdown_price(Request $request)
    {
        $id_item = $request->id_item;
        $jml = $request->jml;
        $products = DB::table('harga')
            ->selectRaw("harga.*,satuan,stok")
            ->Join('item', 'item.id', '=', 'harga.id_item')
            ->Join('satuan', 'satuan.id', '=', 'item.id_satuan')
            ->whereNull('harga.deleted_at')
            ->where('item.id', $id_item)
            ->where('jml', '<=', $jml)
            ->orderby('jml', 'desc')
            ->limit(1)
            ->first();

        return response()->json(['products' => $products]);
    }
}
