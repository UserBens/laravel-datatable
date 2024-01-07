<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;


class BukuController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $buku = Buku::query();
            return DataTables::of($buku)

                ->make();
        }
        return view('bukuhome');
    }
}
