<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FileShare;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;

class FileTransferController extends Controller
{
    /**
     * Show the file transfer UI
     */
    public function index()
    {
        $this->lazyCleanup();
        return view('share.index');
    }

    /**
     * Handle file upload
     */
    public function store(Request $request)
    {
        $this->lazyCleanup();

        $request->validate([
            'file' => 'required|file|max:51200', // 50MB limit
        ], [
            'file.max' => 'ফাইল সাইজ সর্বোচ্চ ৫০ মেগাবাইট হতে পারবে।'
        ]);

        $file = $request->file('file');
        $originalName = $file->getClientOriginalName();
        $fileName = Str::random(40) . '.' . $file->getClientOriginalExtension();
        $fileSize = $file->getSize();

        // Store file in public/shares directory
        $path = $file->storeAs('shares', $fileName, 'public');

        // Generate a unique 4-6 digit PIN
        $pin = $this->generateUniquePin();

        // Create database record
        $fileShare = FileShare::create([
            'file_name' => $fileName,
            'original_name' => $originalName,
            'pin_code' => $pin,
            'file_size' => $this->formatBytes($fileSize),
            'expires_at' => Carbon::now()->addHours(24),
        ]);

        return response()->json([
            'success' => true,
            'pin' => $pin,
            'message' => 'ফাইল সফলভাবে আপলোড হয়েছে।'
        ]);
    }

    /**
     * Download a file using PIN
     */
    public function download(Request $request)
    {
        $request->validate([
            'pin' => 'required|string'
        ]);

        $fileShare = FileShare::where('pin_code', $request->pin)->first();

        if (!$fileShare) {
            return back()->with('error', 'ভুল পিন কোড! দয়া করে সঠিক পিন দিন।');
        }

        if ($fileShare->expires_at < Carbon::now()) {
            // Delete expired file
            Storage::disk('public')->delete('shares/' . $fileShare->file_name);
            $fileShare->delete();
            return back()->with('error', 'এই ফাইলটির মেয়াদ শেষ হয়ে গেছে (২৪ ঘণ্টা পার হয়েছে)।');
        }

        $filePath = 'shares/' . $fileShare->file_name;
        
        if (!Storage::disk('public')->exists($filePath)) {
            $fileShare->delete();
            return back()->with('error', 'ফাইলটি সার্ভারে পাওয়া যায়নি।');
        }

        return Storage::disk('public')->download($filePath, $fileShare->original_name);
    }

    /**
     * Generate a unique 6-digit PIN
     */
    private function generateUniquePin()
    {
        do {
            $pin = str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);
        } while (FileShare::where('pin_code', $pin)->exists());

        return $pin;
    }

    /**
     * Format bytes to human readable format
     */
    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= (1 << (10 * $pow));

        return round($bytes, $precision) . ' ' . $units[$pow];
    }

    /**
     * Lazy cleanup for expired files
     */
    private function lazyCleanup()
    {
        $expiredFiles = FileShare::where('expires_at', '<', Carbon::now())->get();
        foreach ($expiredFiles as $file) {
            Storage::disk('public')->delete('shares/' . $file->file_name);
            $file->delete();
        }
    }
}
