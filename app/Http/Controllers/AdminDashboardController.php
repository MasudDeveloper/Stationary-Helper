<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PaymentRequest;
use App\Models\Ticket;
use App\Models\AiTemplate;
use App\Models\LocalAd;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Statistics
        $totalUsers = User::where('role', '!=', 'admin')->count();
        $pendingPaymentsCount = PaymentRequest::where('status', 'pending')->count();
        $pendingPaymentsSum = PaymentRequest::where('status', 'pending')->sum('amount');
        $openTicketsCount = Ticket::where('status', 'open')->count();
        $totalAiTemplates = AiTemplate::count();
        $activeAds = LocalAd::where('is_active', true)->count();

        // Recent users
        $recentUsers = User::where('role', '!=', 'admin')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Recent payments
        $recentPayments = PaymentRequest::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'pendingPaymentsCount',
            'pendingPaymentsSum',
            'openTicketsCount',
            'totalAiTemplates',
            'activeAds',
            'recentUsers',
            'recentPayments'
        ));
    }
}
