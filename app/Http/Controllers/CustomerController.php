<?php

namespace App\Http\Controllers;

use App\Helper\AlertHelper;
use App\Models\CustomerModels;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    protected $menu = 'master';
    protected $submenu = 'customer';

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
            'lists' => CustomerModels::all()
        ];
        return view('customer.List')->with($data);
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
        return view('customer.Add')->with($data);
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
            $save = new CustomerModels();
            $save->nama = $request->customer;
            $save->kontak = $request->kontak;
            $save->alamat = $request->alamat;
            $save->save();

            DB::commit();
            AlertHelper::addAlert(true);
            return redirect('customer');
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
        $list = CustomerModels::findOrFail(Crypt::decryptString($id));

        $data = [
            'menu' => $this->menu,
            'submenu' => $this->submenu,
            'label' => 'ubah ' . $this->submenu,
            'list' => $list
        ];

        return view('customer.Edit')->with($data);
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
            $save = CustomerModels::findOrFail($decrypted_id);
            $save->nama = $request->customer;
            $save->kontak = $request->kontak;
            $save->alamat = $request->alamat;
            $save->save();

            DB::commit();
            AlertHelper::updateAlert(true);
            return redirect('customer');
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
            $save = CustomerModels::findOrFail($decrypted_id);
            $save->delete();

            DB::commit();
            AlertHelper::deleteAlert(true);
            return redirect('customer');
        } catch (\Throwable $err) {
            DB::rollBack();
            AlertHelper::deleteAlert(false);
            return back();
        }
    }
}
