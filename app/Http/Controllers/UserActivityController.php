<?php

namespace App\Http\Controllers;
use App\Models\UserActivity;
use App\Exports\ActivityExport;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use PDF;

class UserActivityController extends Controller
{
    public function tampil()
    {
    $activities = UserActivity::with('user')->orderBy('created_at', 'desc')->paginate(20);
        return view('laporan.activity.tampil', compact('activities'));
    }


    
    public function exportExcel()
    {
        $date = now()->format('Y-m-d');
        $query = UserActivity::with('user')->orderBy('created_at', 'desc');

        $activity = $query->get();

        UserActivity::create([
            'user_id' => Auth::id(),
            'activity' => 'User telah melakukan export excel laporan user activity ', 
        ]);

        return Excel::download(new ActivityExport($activity), 'laporan aktivitas_'  . $date . '.xlsx');
    }
    public function exportPDF()
    {
        $date = now()->format('Y-m-d');
        $query = UserActivity::with('user')->orderBy('created_at', 'desc'); // Gunakan Activity bukan Transaction

        $activities = $query->get();

        $pdf = PDF::loadView('laporan.activity.activity_pdf', compact('activities')); // Ubah view dan compact data

        UserActivity::create([
            'user_id' => Auth::id(),
            'activity' => 'User telah melakukan export pdf laporan user activity', // Ubah deskripsi aktivitas
        ]);

        return $pdf->stream('laporan aktivitas_' . $date . '.pdf'); // Ubah nama file output
    }
}
