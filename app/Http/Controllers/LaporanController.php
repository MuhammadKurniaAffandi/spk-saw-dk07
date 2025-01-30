<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    //
    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $data = Laporan::orderBy('id', 'DESC')->paginate(10);
        $keputusan = Laporan::all();
        return view('admin.laporan.index', compact('data', 'keputusan'));
    }
}
