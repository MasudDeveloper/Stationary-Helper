<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class WhatsAppController extends Controller
{
    /**
     * Show WhatsApp Connection Status/QR Page
     */
    public function index()
    {
        $userId = Auth::id();
        $status = 'DISCONNECTED';
        $pushname = '';
        $wid = '';

        $whatsappUrl = env('WHATSAPP_SERVER_URL', (request()->getHost() === 'localhost' || request()->getHost() === '127.0.0.1') ? 'http://localhost:3001' : 'https://whatsapp.' . preg_replace('/^www\./', '', request()->getHost()));

        try {
            $response = Http::timeout(5)->get("{$whatsappUrl}/status/{$userId}");
            if ($response->successful()) {
                $data = $response->json();
                $status = $data['status'];
                if ($status === 'CONNECTED') {
                    $pushname = $data['pushname'] ?? '';
                    $wid = $data['wid'] ?? '';
                }
            }
        } catch (\Exception $e) {
            $status = 'SERVER_OFFLINE';
        }

        return view('whatsapp.index', compact('status', 'pushname', 'wid', 'userId'));
    }

    /**
     * Logout from WhatsApp
     */
    public function logout(Request $request)
    {
        $userId = Auth::id();
        $whatsappUrl = env('WHATSAPP_SERVER_URL', (request()->getHost() === 'localhost' || request()->getHost() === '127.0.0.1') ? 'http://localhost:3001' : 'https://whatsapp.' . preg_replace('/^www\./', '', request()->getHost()));
        try {
            $response = Http::post("{$whatsappUrl}/logout", [
                'userId' => $userId
            ]);
            
            if ($response->successful() && $response->json('success')) {
                return redirect()->back()->with('success', 'WhatsApp disconnected successfully.');
            }
        } catch (\Exception $e) {
            // Error
        }
        
        return redirect()->back()->with('error', 'Failed to disconnect WhatsApp. Server might be offline.');
    }
}
