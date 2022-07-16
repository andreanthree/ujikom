<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;

use App\Http\Requests\Admin\UserChangePassRequest;

use DataTables;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables as FacadesDataTables;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            return $next($request);
        });
    }
    public function json(){
        $data = User::where('role', 'USER');

        return FacadesDataTables::of($data)
        ->addIndexColumn()
        ->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.admin.user.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.admin.user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data['password'] = bcrypt($data['password']);
        
        if(User::create($data)) {
            $request->session()->flash('alert-success', 'User '.$data['name'].' berhasil ditambahkan');
        } else {
            $request->session()->flash('alert-failed', 'User '.$data['name'].' gagal ditambahkan');
        }

        return redirect()->route('user.index');
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
        $item = User::select('id', 'name')->where('id', $id)->first();

        return view('pages.admin.user.edit', [
            'item'  => $item 
        ]);
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
        $data = $request->all();
        $item = User::findOrFail($id);

        if($item->update($data)) {
            $request->session()->flash('alert-success', 'User '.$data['name'].' berhasil diupdate');
        } else {
            $request->session()->flash('alert-failed', 'User '.$data['name'].' gagal diupdate');
        }
        
        return redirect()->route('user.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = User::findOrFail($id);
        
        if($item->delete()) {
            session()->flash('alert-success', 'User '.$item->name.' berhasil dihapus!');
        } else {
            session()->flash('alert-failed', 'User '.$item->name.' gagal dihapus');
        }

        return redirect()->route('user.index');
    }

    public function change_pass($id)
    {
        $item = User::select('id', 'name')->where('id', $id)->first();

        return view('pages.admin.user.change-pass', [
            'item'  => $item 
        ]);
    }

    public function update_pass(Request $request, $id)
    {
        $data['password'] = bcrypt($request->input('password'));

        $item = User::findOrFail($id);

        if($item->update(['password'=> $data['password']])) {
            session()->flash('alert-success', 'Password User '.$item->name.' berhasil diupdate');
        } else {
            session()->flash('alert-failed', 'Password User '.$item->name.' gagal diupdate');
        }
        
        return redirect()->route('user.index');
    }
}
