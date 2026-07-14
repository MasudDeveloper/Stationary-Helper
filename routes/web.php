<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
    Route::get('register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('register', [AuthController::class, 'register']);
});

use App\Http\Controllers\PaymentController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\Admin\DocumentCategoryController;
use App\Http\Controllers\Admin\DocumentTemplateController;
use App\Http\Controllers\AccountingController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\DesignAiController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\AdController;
use App\Http\Controllers\AiTemplateController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminPdfToolController;

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Payment Routes
    Route::get('/recharge', [PaymentController::class, 'recharge'])->name('recharge');
    Route::post('/recharge', [PaymentController::class, 'submitRecharge']);

    // Document & CV Maker Routes
    Route::get('/documents', [DocumentController::class, 'index'])->name('document.index');
    Route::get('/documents/{id}/fill', [DocumentController::class, 'fill'])->name('document.fill');

    // Accounting Routes
    Route::get('/accounting', [AccountingController::class, 'index'])->name('accounting.index');
    Route::post('/accounting/store', [AccountingController::class, 'storeTransaction'])->name('accounting.store');
    Route::post('/accounting/delete/{id}', [AccountingController::class, 'destroyTransaction'])->name('accounting.delete');

    // Daily Cash Calculator
    Route::get('/cash-calculator', [AccountingController::class, 'cashCalculator'])->name('accounting.calculator');
    Route::post('/cash-calculator/store', [AccountingController::class, 'storeCashRecord'])->name('accounting.calculator.store');

    // Memo & Receipt Generators
    Route::get('/receipt', [AccountingController::class, 'receiptGenerator'])->name('accounting.receipt');
    Route::get('/memo', [AccountingController::class, 'memoGenerator'])->name('accounting.memo');

    // Ticket / Support / Custom Hiring Routes
    Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
    Route::post('/tickets/store', [TicketController::class, 'store'])->name('tickets.store');
    Route::get('/tickets/{id}', [TicketController::class, 'show'])->name('tickets.show');
    Route::post('/tickets/{id}/message', [TicketController::class, 'storeMessage'])->name('tickets.message');
    Route::post('/tickets/{id}/close', [TicketController::class, 'closeTicket'])->name('tickets.close');

    // Design & AI Routes
    Route::get('/design/editor', [DesignAiController::class, 'graphicsEditor'])->name('design.editor');
    Route::get('/design/ai-hub', [DesignAiController::class, 'aiHub'])->name('design.ai_hub');
    Route::post('/design/ai-hub/generate', [DesignAiController::class, 'generateImage'])->name('design.ai_hub.generate');
    Route::post('/design/ai-hub/bg-remove', [DesignAiController::class, 'removeBackground'])->name('design.ai_hub.bg_remove');

    // Question Generator Routes
    Route::get('/questions', [QuestionController::class, 'index'])->name('questions.index');
    Route::get('/questions/create', [QuestionController::class, 'create'])->name('questions.create');
    Route::post('/questions/store', [QuestionController::class, 'store'])->name('questions.store');
    Route::get('/questions/{id}', [QuestionController::class, 'show'])->name('questions.show');
    Route::post('/questions/{id}/delete', [QuestionController::class, 'destroy'])->name('questions.delete');

    // PDF Editor & Tools Routes
    Route::get('/pdf/editor', [PdfController::class, 'editor'])->name('pdf.editor');
    Route::get('/pdf/tools', [PdfController::class, 'tools'])->name('pdf.tools');
    
    // Feature 1 & 2
    Route::get('/pdf/tools/page-remove', [PdfController::class, 'pageRemove'])->name('pdf.tools.page_remove');
    Route::get('/pdf/tools/watermark', [PdfController::class, 'watermark'])->name('pdf.tools.watermark');
    
    // Feature 3 & 4
    Route::get('/pdf/tools/image-extract', [PdfController::class, 'imageExtract'])->name('pdf.tools.image_extract');
    Route::get('/pdf/tools/permission', [PdfController::class, 'pdfPermission'])->name('pdf.tools.permission');

    // Feature 5 & 6
    Route::get('/pdf/tools/resize', [PdfController::class, 'pdfResize'])->name('pdf.tools.resize');
    Route::get('/pdf/tools/crop', [PdfController::class, 'pdfCrop'])->name('pdf.tools.crop');

    // Feature 7 & 8
    Route::get('/pdf/tools/to-excel', [PdfController::class, 'pdfToExcel'])->name('pdf.tools.to_excel');
    Route::get('/pdf/tools/repair', [PdfController::class, 'pdfRepair'])->name('pdf.tools.repair');

    // Feature 9 & 10
    Route::get('/pdf/tools/image-compress', [PdfController::class, 'imageCompress'])->name('pdf.tools.image_compress');
    Route::get('/pdf/tools/nid-to-pdf', [PdfController::class, 'nidToPdf'])->name('pdf.tools.nid_to_pdf');

    // Feature 11 & 12
    Route::get('/pdf/tools/bg-remover', [PdfController::class, 'bgRemover'])->name('pdf.tools.bg_remover');
    Route::get('/pdf/tools/job-photo', [PdfController::class, 'jobPhoto'])->name('pdf.tools.job_photo');

    // Feature 13 to 16
    Route::get('/pdf/tools/passport-to-pdf', [PdfController::class, 'passportToPdf'])->name('pdf.tools.passport_to_pdf');
    Route::get('/pdf/tools/image-convert', [PdfController::class, 'imageConvert'])->name('pdf.tools.image_convert');
    Route::get('/pdf/tools/qr-generator', [PdfController::class, 'qrGenerator'])->name('pdf.tools.qr_generator');
    Route::get('/pdf/tools/image-resize', [PdfController::class, 'imageResize'])->name('pdf.tools.image_resize');

    // AI Template Generator Routes
    Route::get('/design/ai-templates', [AiTemplateController::class, 'index'])->name('design.ai_templates');
    Route::get('/design/ai-templates/{id}/customize', [AiTemplateController::class, 'customize'])->name('design.ai_templates.customize');
    Route::post('/design/ai-templates/{id}/process', [AiTemplateController::class, 'process'])->name('design.ai_templates.process');

    // Admin Control Panel routes (only for admins)
    Route::middleware(\App\Http\Middleware\IsAdmin::class)->prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
        
        // Payments
        Route::get('/payments', [PaymentController::class, 'adminPayments'])->name('admin.payments');
        Route::post('/payments/{id}/approve', [PaymentController::class, 'approvePayment'])->name('admin.payments.approve');
        Route::post('/payments/{id}/reject', [PaymentController::class, 'rejectPayment'])->name('admin.payments.reject');

        // Document Categories & Templates
        Route::resource('categories', DocumentCategoryController::class, ['as' => 'admin'])->except(['show']);
        Route::resource('templates', DocumentTemplateController::class, ['as' => 'admin'])->except(['show']);

        // Tickets
        Route::get('/tickets', [TicketController::class, 'adminIndex'])->name('admin.tickets');
        Route::get('/tickets/{id}', [TicketController::class, 'adminShow'])->name('admin.tickets.show');

        // Local Ads
        Route::get('/ads', [AdController::class, 'index'])->name('admin.ads');
        Route::post('/ads', [AdController::class, 'store'])->name('admin.ads.store');
        Route::post('/ads/{id}/toggle', [AdController::class, 'toggle'])->name('admin.ads.toggle');
        Route::post('/ads/{id}/delete', [AdController::class, 'destroy'])->name('admin.ads.delete');

        // AI Templates
        Route::get('/ai-templates', [AiTemplateController::class, 'adminIndex'])->name('admin.ai_templates');
        Route::post('/ai-templates', [AiTemplateController::class, 'adminStore'])->name('admin.ai_templates.store');
        Route::post('/ai-templates/{id}/delete', [AiTemplateController::class, 'adminDestroy'])->name('admin.ai_templates.delete');

        // PDF Tools Settings
        Route::get('/pdf-tools', [AdminPdfToolController::class, 'index'])->name('admin.pdf_tools');
        Route::post('/pdf-tools/{id}/toggle', [AdminPdfToolController::class, 'toggle'])->name('admin.pdf_tools.toggle');
    });
});
