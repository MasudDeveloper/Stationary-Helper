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
        $tools = \App\Models\PdfTool::where('is_active', true)->orderBy('order')->get();
        return view('pdf.tools', compact('tools'));
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

    public function jobPhoto()
    {
        return view('pdf.tools_job_photo');
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
}
