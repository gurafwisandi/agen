<?php

namespace App\Http\Controllers;

use App\Helper\AlertHelper;
use App\Models\SatuanModels;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class SatuanController extends Controller
{
    protected $menu = 'master';
    protected $submenu = 'satuan';

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
            'lists' => SatuanModels::all()
        ];
        return view('satuan.List')->with($data);
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
        ];
        return view('satuan.Add')->with($data);
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
            $save = new SatuanModels();
            $save->satuan = $request->satuan;
            $save->save();

            DB::commit();
            AlertHelper::addAlert(true);
            return redirect('satuan');
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
        $list = SatuanModels::findOrFail(Crypt::decryptString($id));

        $data = [
            'menu' => $this->menu,
            'submenu' => $this->submenu,
            'label' => 'ubah ' . $this->submenu,
            'list' => $list
        ];

        return view('satuan.Edit')->with($data);
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
            $save = SatuanModels::findOrFail($decrypted_id);
            $save->satuan = $request->satuan;
            $save->save();

            DB::commit();
            AlertHelper::updateAlert(true);
            return redirect('satuan');
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
            $save = SatuanModels::findOrFail($decrypted_id);
            $save->delete();

            DB::commit();
            AlertHelper::deleteAlert(true);
            return redirect('satuan');
        } catch (\Throwable $err) {
            DB::rollBack();
            AlertHelper::deleteAlert(false);
            return back();
        }
    }
}
