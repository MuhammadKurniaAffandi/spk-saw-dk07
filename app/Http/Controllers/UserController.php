<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Exception;
// use PDF;
use Carbon\Carbon;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data['users'] = User::latest()->paginate(10);
        return view('admin.user.index', $data);
        // $data['user'] = User::get();
        // return view('admin.user.index', $data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [

            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            /* 'alamat' => 'required|string',
            'telepon' => 'required|string', */
            'keterangan' => 'required|string',

        ]);

        try {

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            /* $user->alamat = $request->alamat;
            $user->telepon = $request->telepon; */
            $user->keterangan = $request->keterangan;

            $user->save();
            return back()->with('msg', 'Berhasil Menambahkan Data');
        } catch (Exception $e) {
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            die("Gagal");
        }
    }

    /* awal - untuk mengangani update data user sesuai yang dipilih dari menu data pengguna  */
    public function edit($id)
    {
        $data['users'] = User::findOrFail($id);
        return view('admin.user.edit', $data);
    }


    public function update(Request $request, $id)
    {

        $this->validate($request, [

            'name' => ['required', 'string', 'max:255'],
            // 'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            // 'password' => ['required', 'string', 'min:8'],
            /* 'alamat' => 'required|string',
            'telepon' => 'required|string', */
            'keterangan' => 'required|string',

        ]);

        try {


            $user = User::findOrFail($id);
            $user->update([
                'name' => $request->name,
                // 'email' => $request->email,
                /* 'alamat' => $request->alamat,
                'telepon' => $request->telepon, */
                'keterangan' => $request->keterangan

            ]);
            return back()->with('msg', 'Berhasil Mengubah Data');
        } catch (Exception $e) {
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            die("Gagal");
        }
    }
    /* awal - untuk mengangani update data user sesuai yang dipilih dari menu data pengguna  */


    public function destroy($id)
    {

        try {

            $user = User::findOrFail($id);
            $user->delete();
        } catch (Exception $e) {
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            die("Gagal");
        }
    }

    public function downloadPDF()
    {
        // setlocale(LC_ALL, 'IND');
        // $tanggal = Carbon::now()->formatLocalized(' %d %B %Y');
        $tanggal = Carbon::now()->translatedFormat('d F Y'); // ** Output: "01 Maret 2019" **
        $user = User::get();

        $pdf = PDF::loadView('admin.user.user-pdf', compact('user', 'tanggal'));
        $pdf->setPaper('A4', 'potrait');
        return $pdf->stream('user.pdf');
    }
}
