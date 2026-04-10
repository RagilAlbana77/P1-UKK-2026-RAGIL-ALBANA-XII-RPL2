<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function index(Request $request): View
    {
        $query = Peminjaman::with(['user', 'alat'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->string('status'));
        }

        if ($request->filled('date_from')) {
            $query->whereDate('tanggal_pinjam', '>=', $request->date('date_from'));
        }

        if ($request->filled('date_to')) {
            $query->whereDate('tanggal_pinjam', '<=', $request->date('date_to'));
        }

        $reports = $query->paginate(10)->withQueryString();

        return view('reports.index', [
            'reports' => $reports,
            'totalAlat' => Alat::count(),
            'totalDipinjam' => (int) Peminjaman::where('status', Peminjaman::STATUS_DIPINJAM)->sum('qty'),
            'totalDikembalikan' => Peminjaman::where('status', Peminjaman::STATUS_DIKEMBALIKAN)->count(),
        ]);
    }
}
