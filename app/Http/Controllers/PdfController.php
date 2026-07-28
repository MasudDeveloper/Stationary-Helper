<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PdfController extends Controller
{
    public function editor()
    {
        return view('pdf.editor');
    }

    public function tools()
    {
        if (\App\Models\PdfTool::where('route_name', 'pdf.tools.joint_photo')->doesntExist()) {
            \App\Models\PdfTool::updateOrCreate(
                ['title' => 'যৌথ পাসপোর্ট ছবি (Husband-Wife)'],
                ['icon' => 'people_alt', 'gradient_class' => 'grad-purple', 'is_hot' => true, 'route_name' => 'pdf.tools.joint_photo', 'order' => 17, 'is_active' => true]
            );
        }
        if (\App\Models\PdfTool::where('route_name', 'pdf.tools.document_scanner')->doesntExist()) {
            \App\Models\PdfTool::updateOrCreate(
                ['title' => 'ছবি ও ডকুমেন্ট সোজা করুন (CamScanner)'],
                ['icon' => 'document_scanner', 'gradient_class' => 'grad-pink', 'is_hot' => true, 'route_name' => 'pdf.tools.document_scanner', 'order' => 18, 'is_active' => true]
            );
        }
        if (\App\Models\PdfTool::where('route_name', 'pdf.tools.jpg_to_pdf')->doesntExist()) {
            \App\Models\PdfTool::updateOrCreate(
                ['title' => 'জেপিজি টু পিডিএফ (JPG to PDF)'],
                ['icon' => 'picture_as_pdf', 'gradient_class' => 'grad-red', 'is_hot' => true, 'route_name' => 'pdf.tools.jpg_to_pdf', 'order' => 19, 'is_active' => true]
            );
        }
        $tools = \App\Models\PdfTool::where('is_active', true)->orderBy('order')->get();
        
        $pdfTitles = [
            'পেজ রিমুভ', 'পিডিএফ ওয়াটারমার্ক', 'পিডিএফ পারমিশন', 'পিডিএফ রিসাইজ', 
            'পিডিএফ ক্রপ', 'পিডিএফ টু এক্সেল', 'পিডিএফ রিপেয়ার', 'এনআইডি টু পিডিএফ', 
            'পাসপোর্ট টু পিডিএফ', 'জেপিজি টু পিডিএফ (JPG to PDF)', 'ছবি ও ডকুমেন্ট সোজা করুন (CamScanner)'
        ];

        $pdfTools = $tools->filter(function($tool) use ($pdfTitles) {
            return in_array($tool->title, $pdfTitles) || str_contains(strtolower($tool->title), 'pdf') || str_contains($tool->title, 'পিডিএফ');
        });

        $imageTools = $tools->reject(function($tool) use ($pdfTools) {
            return $pdfTools->contains('id', $tool->id);
        });

        return view('pdf.tools', compact('tools', 'pdfTools', 'imageTools'));
    }

    public function pageRemove()
    {
        return view('pdf.tools_page_remove');
    }

    public function watermark()
    {
        return view('pdf.tools_watermark');
    }

    public function imageExtract()
    {
        return view('pdf.tools_image_extract');
    }

    public function pdfPermission()
    {
        return view('pdf.tools_pdf_permission');
    }

    public function pdfResize()
    {
        return view('pdf.tools_pdf_resize');
    }

    public function pdfCrop()
    {
        return view('pdf.tools_pdf_crop');
    }

    public function pdfToExcel()
    {
        return view('pdf.tools_pdf_to_excel');
    }

    public function pdfRepair()
    {
        return view('pdf.tools_pdf_repair');
    }

    public function imageCompress()
    {
        return view('pdf.tools_image_compress');
    }

    public function nidToPdf()
    {
        return view('pdf.tools_nid_to_pdf');
    }

    public function bgRemover()
    {
        return view('pdf.tools_bg_remover');
    }

    public function deductBgRemoverCredit(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = \Illuminate\Support\Facades\Auth::user();
        $cost = 5;

        if ($user->credits < $cost) {
            return response()->json(['success' => false, 'message' => 'অপর্যাপ্ত ক্রেডিট! দয়া করে রিচার্জ করুন।']);
        }

        $user->credits -= $cost;
        $user->save();

        // Log transaction
        \App\Models\AccountingTransaction::create([
            'user_id' => $user->id,
            'type' => 'debit',
            'amount' => $cost,
            'description' => 'Background Removal Tool Usage',
            'date' => now(),
        ]);

        return response()->json([
            'success' => true,
            'new_balance' => number_format($user->credits)
        ]);
    }

    public function jobPhoto()
    {
        return view('pdf.tools_job_photo');
    }

    public function passportPrint()
    {
        return view('pdf.tools_passport_print');
    }

    public function passportToPdf()
    {
        return view('pdf.tools_passport_to_pdf');
    }

    public function imageConvert()
    {
        return view('pdf.tools_image_convert');
    }

    public function qrGenerator()
    {
        return view('pdf.tools_qr_generator');
    }

    public function imageResize()
    {
        return view('pdf.tools_image_resize');
    }

    public function jointPhoto()
    {
        return view('pdf.tools_joint_photo');
    }

    public function documentScanner()
    {
        return view('pdf.tools_document_scanner');
    }

    public function jpgToPdf()
    {
        return view('pdf.tools_jpg_to_pdf');
    }
}
