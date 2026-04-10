<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class ActivityLogController extends Controller
{
    public function index(): View
    {
        $activities = $this->buildActivities();

        return view('activity.index', [
            'activities' => $activities,
        ]);
    }

    private function buildActivities(): Collection
    {
        return Peminjaman::with(['user', 'alat'])
            ->latest()
            ->limit(30)
            ->get()
            ->map(function (Peminjaman $item): array {
                return [
                    'waktu' => $item->updated_at,
                    'user' => $item->user?->name ?? '-',
                    'aktivitas' => strtoupper($item->status) . ' - ' . ($item->alat?->nama_alat ?? 'Alat'),
                    'ip' => request()->ip(),
                    'status' => $item->status,
                ];
            });
    }
}
