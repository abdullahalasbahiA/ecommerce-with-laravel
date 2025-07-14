<?php

namespace App\Http\Controllers;

use App\Enums\PaymentStatus;
use Illuminate\Http\Request;
use App\Models\Payment;


class DashboardController extends Controller
{

    public function index()
    {
        // ✅ حساب كل حالة من حالات الدفع باستخدام Enum
        $completedPayments = Payment::where('status', PaymentStatus::COMPLETED)->count();
        $pendingPayments = Payment::where('status', PaymentStatus::PENDING)->count();
        $failedPayments = Payment::where('status', PaymentStatus::FAILED)->count();

        // ✅ عرضهم في الرسم البياني الدائري
        $paymentStatuses = ['Completed', 'Pending', 'Failed'];
        $paymentCounts = [$completedPayments, $pendingPayments, $failedPayments];

        // ✅ إحصائيات أخرى
        $totalPayments = $completedPayments + $pendingPayments + $failedPayments;
        $totalRevenue = Payment::where('status', PaymentStatus::COMPLETED)->sum('amount');

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

    public function indexOLD()
    {
        // ⚡ حساب عدد كل حالة من حالات الدفع
        $completedPayments = Payment::where('status', PaymentStatus::COMPLETED)->count();
        // يمكنك استخدام PaymentStatus::PENDING و PaymentStatus::FAILED إذا كنت تستخدم Enum
        // إذا لم تكن تستخدم Enum، يمكنك استخدام القيم النصية مباشرة
        // $completedPayments = Payment::where('status', 'Completed')->count();
        $pendingPayments = Payment::where('status', PaymentStatus::PENDING)->count();
        // $pendingPayments = Payment::where('status', 'PENDING')->count();
        $failedPayments = Payment::where('status', PaymentStatus::FAILED)->count();
        // $failedPayments = Payment::where('status', 'FAILED')->count(); // غيّر الاسم حسب نظامك
        // $pendingPayments = Payment::where('status', 'PENDING')->count();
        // $failedPayments = Payment::where('status', 'FAILED')->count(); // غيّر الاسم حسب نظامك

        // ⚡ جمع البيانات في مصفوفات للعرض في الرسم البياني
        $paymentStatuses = ['مكتملة', 'معلقة', 'فاشلة'];
        $paymentCounts = [$completedPayments, $pendingPayments, $failedPayments];

        return view('admin.dashboard', compact(
            'completedPayments',
            'pendingPayments',
            'failedPayments',
            'paymentStatuses',
            'paymentCounts',
        ));
    }
    // public function index()
    // {
    //     // اجمالي المدفوعات
    //     $totalPayments = Payment::count();

    //     // المدفوعات المكتملة
    //     $completedPayments = Payment::where('status', 'Completed')->count();

    //     // المدفوعات المعلقة
    //     $pendingPayments = Payment::where('status', 'PENDING')->count();

    //     // اجمالي الإيرادات
    //     $totalRevenue = Payment::where('status', 'Completed')->sum('amount'); // غيّر الحقل حسب اسم عمود السعر عندك

    //     // تحليل المبيعات لآخر 7 أيام
    //     $sales = Payment::where('status', 'Completed')
    //         ->whereDate('created_at', '>=', now()->subDays(6))
    //         ->selectRaw('DATE(created_at) as date, SUM(amount) as total')
    //         ->groupBy('date')
    //         ->orderBy('date')
    //         ->get();

    //     $salesLabels = $sales->pluck('date')->toArray();
    //     $salesData = $sales->pluck('total')->toArray();

    //     return view('admin.dashboard', compact(
    //         'totalPayments',
    //         'completedPayments',
    //         'pendingPayments',
    //         'totalRevenue',
    //         'salesLabels',
    //         'salesData'
    //     ));
    // }

}
