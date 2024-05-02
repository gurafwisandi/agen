<?php

namespace App\Http\Controllers;

use App\Helper\AlertHelper;
use App\Models\CabangModels;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserController extends Controller
{
    protected $menu = 'master';
    protected $submenu = 'user';

    public function __construct()
    {
        $this->middleware('auth');
    }

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
            'lists' => User::all()
        ];
        return view('user.ListUser')->with($data);
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
            'cabang' => CabangModels::all(),
        ];
        return view('user.AddUser')->with($data);
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
            $user = new User();
            $user->name = $request->username;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->id_cabang = $request->cabang;
            $user->status = 'A';
            $user->save();

            DB::commit();
            AlertHelper::addAlert(true);
            return redirect('user');
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
    public function edit(Request $request)
    {
        $id_decrypted = Crypt::decryptString($request->id);
        $data = [
            'menu' => $this->menu,
            'submenu' => $this->submenu,
            'label' => 'ubah ' . $this->submenu,
            'user' => User::findorfail($id_decrypted),
            'cabang' => CabangModels::all(),
        ];
        return view('user.EditUser')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'file' => 'mimes:png,jpeg,jpg|max:2048'
        ]);

        DB::beginTransaction();
        try {
            $user = User::findorfail($request->id);
            $user->name = $request->username;
            $user->email = $request->email;
            if ($request->password !== $request->password_old) {
                $user->password = bcrypt($request->password);
            }
            $user->status = isset($request->status) ? 'A' : '';
            if ($request->file()) {
                $fileName = Carbon::now()->format('ymdhis') . '_' . $request->id . '_' . str::random(25) . '.' . $request->file->extension();
                $user->foto = $fileName;
                $request->file->move(public_path('files/foto'), $fileName);
            }
            $user->id_cabang = $request->cabang;
            $user->save();

            DB::commit();
            AlertHelper::updateAlert(true);
            return redirect('user');
        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
            // something went wrong
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id_decrypted = Crypt::decryptString($request->id);
        DB::beginTransaction();
        try {
            $user = User::findorfail($id_decrypted);
            $user->delete();

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
