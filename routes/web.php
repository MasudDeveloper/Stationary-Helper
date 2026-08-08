<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});

// Public Exam Routes
Route::get('/exams/{id}/participate', [\App\Http\Controllers\ExamController::class, 'participate'])->name('exams.participate');
Route::post('/exams/{id}/submit', [\App\Http\Controllers\ExamController::class, 'submitExam'])->name('exams.submit');
Route::get('/exams/results/{submission_id}', [\App\Http\Controllers\ExamController::class, 'results'])->name('exams.results');

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
use App\Http\Controllers\FileTransferController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\OcrController;
use App\Http\Controllers\CvController;
use App\Http\Controllers\Admin\RechargePackageController;
use App\Http\Controllers\Admin\CvTemplateController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\WhatsAppController;
use App\Http\Controllers\SavedDocumentController;
use App\Http\Controllers\BusinessAccountController;
use App\Http\Controllers\Admin\BusinessUpgradeController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\ShopkeeperOrderController;
use App\Http\Controllers\ReferralController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\GatewayController;

Route::post('/api/payment/callback', [GatewayController::class, 'handleWebhook']);

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Quick Share Routes
    Route::get('/quick-share', [FileTransferController::class, 'index'])->name('share.index');
    Route::post('/quick-share/upload', [FileTransferController::class, 'store'])->name('share.upload');
    Route::post('/quick-share/download', [FileTransferController::class, 'download'])->name('share.download');

    // Photo Maker Routes
    Route::get('/photo', [PhotoController::class, 'index'])->name('photo.index');

    // Payment Routes
    Route::get('/recharge', [PaymentController::class, 'recharge'])->name('recharge');
    Route::post('/recharge', [PaymentController::class, 'submitRecharge']);

    // Business Account Routes
    Route::get('/business/upgrade', [BusinessAccountController::class, 'upgrade'])->name('business.upgrade');
    Route::post('/business/upgrade', [BusinessAccountController::class, 'submitUpgrade']);
    Route::get('/my-orders', [ShopkeeperOrderController::class, 'index'])->name('shopkeeper.orders.index');
    Route::post('/my-orders/{id}/accept', [ShopkeeperOrderController::class, 'accept'])->name('shopkeeper.orders.accept');
    Route::post('/my-orders/{id}/complete', [ShopkeeperOrderController::class, 'complete'])->name('shopkeeper.orders.complete');

    // Subscription Routes
    Route::get('/subscription', [SubscriptionController::class, 'index'])->name('subscription.index');
    Route::post('/subscription/buy', [SubscriptionController::class, 'buy'])->name('subscription.buy');

    // Gateway Payment Routes
    Route::post('/gateway/payment/create', [GatewayController::class, 'createOrder'])->name('gateway.payment.create');
    Route::post('/gateway/payment/status', [GatewayController::class, 'checkStatus'])->name('gateway.payment.status');

    // Referral Routes
    Route::get('/referrals', [ReferralController::class, 'index'])->name('referrals.index');

    // Document & CV Maker Routes
    Route::get('/documents', [DocumentController::class, 'index'])->name('document.index');
    Route::get('/documents/favorites', [DocumentController::class, 'favorites'])->name('document.favorites');
    Route::post('/documents/{id}/favorite', [DocumentController::class, 'toggleFavorite'])->name('document.favorite.toggle');
    Route::post('/documents/{id}/deduct-credit', [DocumentController::class, 'deductCredit'])->name('document.deduct.credit');
    Route::post('/documents/{id}/send-whatsapp', [DocumentController::class, 'sendWhatsApp'])->name('document.whatsapp.send');
    Route::get('/documents/{id}/fill', [DocumentController::class, 'fill'])->name('document.fill');

    Route::get('/cv-maker', [CvController::class, 'index'])->name('cv.index');
    Route::get('/cv-maker/{id}/fill', [CvController::class, 'fill'])->name('cv.fill');
    Route::post('/cv-maker/{id}/deduct-credit', [CvController::class, 'deductCredit'])->name('cv.deduct.credit');
    Route::post('/cv-maker/{id}/send-whatsapp', [CvController::class, 'sendWhatsApp'])->name('cv.whatsapp.send');

    // Saved Documents Routes
    Route::get('/saved-documents', [SavedDocumentController::class, 'index'])->name('saved-documents.index');
    Route::post('/saved-documents', [SavedDocumentController::class, 'store'])->name('saved-documents.store');
    Route::get('/saved-documents/{id}', [SavedDocumentController::class, 'show'])->name('saved-documents.show');
    Route::post('/saved-documents/{id}/delete', [SavedDocumentController::class, 'destroy'])->name('saved-documents.delete');

    // Accounting Routes
    Route::get('/accounting', [AccountingController::class, 'index'])->name('accounting.index');
    Route::post('/accounting/store', [AccountingController::class, 'storeTransaction'])->name('accounting.store');
    Route::post('/accounting/transaction/{id}/delete', [AccountingController::class, 'destroyTransaction'])->name('accounting.transaction.delete');
    
    // Dues (Bakir Hishab) Routes
    Route::get('/accounting/dues', [AccountingController::class, 'dues'])->name('accounting.dues');
    Route::post('/accounting/dues', [AccountingController::class, 'storeDue'])->name('accounting.dues.store');
    Route::post('/accounting/dues/{id}/mark-paid', [AccountingController::class, 'markDuePaid'])->name('accounting.dues.mark_paid');
    Route::post('/accounting/dues/{id}/delete', [AccountingController::class, 'destroyDue'])->name('accounting.dues.delete');

    // Daily Cash Calculator
    Route::get('/cash-calculator', [AccountingController::class, 'cashCalculator'])->name('accounting.calculator');
    Route::post('/cash-calculator/store', [AccountingController::class, 'storeCashRecord'])->name('accounting.calculator.store');

    // Memo & Receipt Generators
    Route::get('/receipt', [AccountingController::class, 'receiptGenerator'])->name('accounting.receipt');
    Route::get('/memo', [AccountingController::class, 'memoGenerator'])->name('accounting.memo');
    Route::post('/accounting/whatsapp/send', [AccountingController::class, 'sendWhatsApp'])->name('accounting.whatsapp.send');

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

    // OCR Routes
    Route::get('/ocr', [OcrController::class, 'index'])->name('ocr.index');
    Route::post('/ocr/deduct-credit', [OcrController::class, 'deductCredit'])->name('ocr.deduct_credit');
    Route::post('/ocr/process-ocr-space', [OcrController::class, 'processOcrSpace'])->name('ocr.process_space');

    // Question Generator Routes
    Route::get('/questions', [QuestionController::class, 'index'])->name('questions.index');
    Route::get('/questions/create', [QuestionController::class, 'create'])->name('questions.create');
    Route::post('/questions/store', [QuestionController::class, 'store'])->name('questions.store');
    Route::get('/questions/{id}', [QuestionController::class, 'show'])->name('questions.show');
    Route::post('/questions/{id}/delete', [QuestionController::class, 'destroy'])->name('questions.delete');

    // PDF Editor & Tools Routes
    Route::get('/pdf/editor', [PdfController::class, 'editor'])->name('pdf.editor');
    Route::get('/pdf/tools', [PdfController::class, 'tools'])->name('pdf.tools');
    
    // Typing Test Routes
    Route::get('/typing-test', [\App\Http\Controllers\TypingTestController::class, 'index'])->name('typing-test.index');
    Route::get('/typing-test/custom', [\App\Http\Controllers\TypingTestController::class, 'custom'])->name('typing-test.custom');
    Route::get('/typing-test/{id}', [\App\Http\Controllers\TypingTestController::class, 'test'])->name('typing-test.test');
    
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
    Route::get('/pdf/tools/to-word', [PdfController::class, 'pdfToWord'])->name('pdf.tools.pdf_to_word');
    Route::get('/pdf/tools/repair', [PdfController::class, 'pdfRepair'])->name('pdf.tools.repair');

    // Feature 9 & 10
    Route::get('/pdf/tools/image-compress', [PdfController::class, 'imageCompress'])->name('pdf.tools.image_compress');
    Route::get('/pdf/tools/nid-to-pdf', [PdfController::class, 'nidToPdf'])->name('pdf.tools.nid_to_pdf');

    // Feature 11 & 12
    Route::get('/pdf/tools/bg-remover', [PdfController::class, 'bgRemover'])->name('pdf.tools.bg_remover');
    Route::post('/pdf/tools/bg-remover/process', [PdfController::class, 'processBgRemover'])->name('pdf.tools.bg_remover.process');
    Route::post('/pdf/tools/bg-remover/deduct', [PdfController::class, 'deductBgRemoverCredit'])->name('pdf.tools.bg_remover.deduct');
    Route::post('/pdf/tools/detect-document-corners', [PdfController::class, 'detectDocumentCorners'])->name('pdf.tools.detect_document_corners');
    Route::post('/pdf/tools/auto-crop-document', [PdfController::class, 'autoCropDocument'])->name('pdf.tools.auto_crop_document');
    Route::get('/pdf/tools/job-photo', [PdfController::class, 'jobPhoto'])->name('pdf.tools.job_photo');
    Route::get('/pdf/tools/passport-print', [PdfController::class, 'passportPrint'])->name('pdf.tools.passport_print');

    // Feature 13 to 16
    Route::get('/pdf/tools/passport-to-pdf', [PdfController::class, 'passportToPdf'])->name('pdf.tools.passport_to_pdf');
    Route::get('/pdf/tools/image-convert', [PdfController::class, 'imageConvert'])->name('pdf.tools.image_convert');
    Route::get('/pdf/tools/qr-generator', [PdfController::class, 'qrGenerator'])->name('pdf.tools.qr_generator');
    Route::get('/pdf/tools/image-resize', [PdfController::class, 'imageResize'])->name('pdf.tools.image_resize');
    Route::get('/pdf/tools/joint-photo', [PdfController::class, 'jointPhoto'])->name('pdf.tools.joint_photo');
    Route::get('/pdf/tools/advanced-photo', [PdfController::class, 'advancedPhoto'])->name('pdf.tools.advanced_photo');
    Route::get('/pdf/tools/document-scanner', [PdfController::class, 'documentScanner'])->name('pdf.tools.document_scanner');
    Route::get('/pdf/tools/jpg-to-pdf', [PdfController::class, 'jpgToPdf'])->name('pdf.tools.jpg_to_pdf');

    // Exam System Routes
    Route::get('/exams', [\App\Http\Controllers\ExamController::class, 'index'])->name('exams.index');
    Route::get('/exams/create', [\App\Http\Controllers\ExamController::class, 'create'])->name('exams.create');
    Route::post('/exams/store', [\App\Http\Controllers\ExamController::class, 'store'])->name('exams.store');
    Route::get('/exams/{id}', [\App\Http\Controllers\ExamController::class, 'show'])->name('exams.show');
    Route::post('/exams/{id}/delete', [\App\Http\Controllers\ExamController::class, 'destroy'])->name('exams.delete');

    // AI Template Generator Routes
    Route::get('/design/ai-templates', [AiTemplateController::class, 'index'])->name('design.ai_templates');
    Route::get('/design/ai-templates/{id}/customize', [AiTemplateController::class, 'customize'])->name('design.ai_templates.customize');
    Route::post('/design/ai-templates/{id}/process', [AiTemplateController::class, 'process'])->name('design.ai_templates.process');

    // WhatsApp Device Linking
    Route::get('/whatsapp/connect', [WhatsAppController::class, 'index'])->name('whatsapp.connect');
    Route::post('/whatsapp/logout', [WhatsAppController::class, 'logout'])->name('whatsapp.logout');

    // Admin Control Panel routes (only for admins)
    Route::middleware(\App\Http\Middleware\IsAdmin::class)->prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
        
        // Users Management
        Route::get('/users', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('admin.users');
        
        // Payments
        Route::get('/payments', [PaymentController::class, 'adminPayments'])->name('admin.payments');
        Route::post('/payments/{id}/approve', [PaymentController::class, 'approvePayment'])->name('admin.payments.approve');
        Route::post('/payments/{id}/reject', [PaymentController::class, 'rejectPayment'])->name('admin.payments.reject');

        // Business Upgrades
        Route::get('/business-upgrades', [BusinessUpgradeController::class, 'index'])->name('admin.business_upgrades');
        Route::post('/business-upgrades/{id}/approve', [BusinessUpgradeController::class, 'approve'])->name('admin.business_upgrades.approve');
        Route::post('/business-upgrades/{id}/reject', [BusinessUpgradeController::class, 'reject'])->name('admin.business_upgrades.reject');

        // Orders
        Route::get('/orders', [AdminOrderController::class, 'index'])->name('admin.orders.index');
        Route::get('/orders/create', [AdminOrderController::class, 'create'])->name('admin.orders.create');
        Route::post('/orders', [AdminOrderController::class, 'store'])->name('admin.orders.store');
        Route::post('/orders/{id}/paid', [AdminOrderController::class, 'markPaid'])->name('admin.orders.paid');

        // Document Categories & Templates
        Route::resource('categories', DocumentCategoryController::class, ['as' => 'admin'])->except(['show']);
        Route::resource('templates', DocumentTemplateController::class, ['as' => 'admin'])->except(['show']);

        // CV Templates
        Route::resource('cv-templates', CvTemplateController::class, ['as' => 'admin'])->except(['show']);

        // Recharge Packages
        Route::resource('recharge-packages', RechargePackageController::class, ['as' => 'admin'])->except(['show']);

        // Settings
        Route::get('/settings', [SettingController::class, 'index'])->name('admin.settings');
        Route::post('/settings', [SettingController::class, 'store'])->name('admin.settings.store');

        // Tickets
        Route::get('/tickets', [TicketController::class, 'adminIndex'])->name('admin.tickets');
        Route::get('/tickets/{id}', [TicketController::class, 'adminShow'])->name('admin.tickets.show');

        // Local Ads
        Route::post('/ads/{id}/delete', [AdController::class, 'destroy'])->name('admin.ads.delete');
        Route::post('/ads/{id}/toggle', [AdController::class, 'toggle'])->name('admin.ads.toggle');
        Route::get('/ads', [AdController::class, 'index'])->name('admin.ads');
        Route::post('/ads', [AdController::class, 'store'])->name('admin.ads.store');

        // AI Templates
        Route::get('/ai-templates', [AiTemplateController::class, 'adminIndex'])->name('admin.ai_templates');
        Route::post('/ai-templates', [AiTemplateController::class, 'adminStore'])->name('admin.ai_templates.store');
        Route::post('/ai-templates/{id}/delete', [AiTemplateController::class, 'adminDestroy'])->name('admin.ai_templates.delete');

        // PDF Tools Settings
        Route::get('/pdf-tools', [AdminPdfToolController::class, 'index'])->name('admin.pdf_tools');
        Route::post('/pdf-tools/{id}/toggle', [AdminPdfToolController::class, 'toggle'])->name('admin.pdf_tools.toggle');

        // Typing Tests
        Route::resource('typing-test', \App\Http\Controllers\Admin\TypingTestController::class, ['as' => 'admin'])->except(['show']);
    });
});
