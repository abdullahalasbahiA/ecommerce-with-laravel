<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // 🟢 حساب عدد المدفوعات لكل حالة
        $completedPayments = Payment::whereRaw('LOWER(status) = ?', ['completed'])->count();
        $pendingPayments = Payment::whereRaw('LOWER(status) = ?', ['pending'])->count();
        $failedPayments = Payment::whereRaw('LOWER(status) = ?', ['failed'])->count();
        // $completedPayments = Payment::where('status', 'Completed')->count();
        // $pendingPayments = Payment::where('status', 'PENDING')->count();
        // $failedPayments = Payment::where('status', 'FAILED')->count(); // غيّره حسب حالتك



        // 🟢 هذه القيم سيتم تمريرها إلى الرسم البياني
        $paymentStatuses = ['Completed', 'Pending', 'Failed'];
        $paymentCounts = [$completedPayments, $pendingPayments, $failedPayments];

        // 🟢 بيانات أخرى قد تكون معك من قبل (للوحة)
        $totalPayments = $completedPayments + $pendingPayments + $failedPayments;
        $totalRevenue = Payment::where('status', PaymentStatus::COMPLETED)->sum('amount');
        // $totalRevenue = Payment::where('status', 'Completed')->sum('amount');

        return view('admin.dashboard', compact(
            'completedPayments',
            'pendingPayments',
            'failedPayments',
            'paymentStatuses',
            'paymentCounts',
            'totalPayments',
            'totalRevenue'
        ));
    }
}
