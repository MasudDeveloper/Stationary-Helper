<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PdfTool;

class PdfToolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tools = [
            // Row 1 (Purple)
            ['title' => 'পেজ রিমুভ', 'icon' => 'auto_delete', 'gradient_class' => 'grad-purple', 'is_hot' => false, 'route_name' => 'pdf.tools.page_remove', 'order' => 1],
            ['title' => 'পিডিএফ ওয়াটারমার্ক', 'icon' => 'branding_watermark', 'gradient_class' => 'grad-purple', 'is_hot' => false, 'route_name' => 'pdf.tools.watermark', 'order' => 2],
            ['title' => 'ইমেজ এক্সট্রাক্ট', 'icon' => 'image_search', 'gradient_class' => 'grad-purple', 'is_hot' => false, 'route_name' => null, 'order' => 3],
            ['title' => 'পিডিএফ পারমিশন', 'icon' => 'admin_panel_settings', 'gradient_class' => 'grad-pink', 'is_hot' => false, 'route_name' => null, 'order' => 4],
            
            // Row 2 (Pink/Red)
            ['title' => 'পিডিএফ রিসাইজ', 'icon' => 'aspect_ratio', 'gradient_class' => 'grad-pink', 'is_hot' => false, 'route_name' => null, 'order' => 5],
            ['title' => 'পিডিএফ ক্রপ', 'icon' => 'crop', 'gradient_class' => 'grad-pink', 'is_hot' => false, 'route_name' => null, 'order' => 6],
            ['title' => 'পিডিএফ টু এক্সেল', 'icon' => 'table_view', 'gradient_class' => 'grad-red', 'is_hot' => false, 'route_name' => null, 'order' => 7],
            ['title' => 'পিডিএফ রিপেয়ার', 'icon' => 'build_circle', 'gradient_class' => 'grad-red', 'is_hot' => false, 'route_name' => null, 'order' => 8],
            
            // Row 3 (Green)
            ['title' => 'ইমেজ কম্প্রেস', 'icon' => 'compress', 'gradient_class' => 'grad-green', 'is_hot' => false, 'route_name' => null, 'order' => 9],
            ['title' => 'এনআইডি টু পিডিএফ', 'icon' => 'badge', 'gradient_class' => 'grad-green', 'is_hot' => true, 'route_name' => null, 'order' => 10],
            ['title' => 'ব্যাকগ্রাউন্ড রিমুভার', 'icon' => 'wallpaper', 'gradient_class' => 'grad-green', 'is_hot' => true, 'route_name' => null, 'order' => 11],
            ['title' => 'জব ফটো ও সিগনেচার রিসাইজ', 'icon' => 'portrait', 'gradient_class' => 'grad-teal', 'is_hot' => false, 'route_name' => null, 'order' => 12],
            
            // Row 4 (Cyan/Blue)
            ['title' => 'পাসপোর্ট টু পিডিএফ', 'icon' => 'contact_page', 'gradient_class' => 'grad-teal', 'is_hot' => true, 'route_name' => null, 'order' => 13],
            ['title' => 'ইমেজ কনভার্ট', 'icon' => 'transform', 'gradient_class' => 'grad-cyan', 'is_hot' => true, 'route_name' => null, 'order' => 14],
            ['title' => 'কিউআর কোড জেনারেটর', 'icon' => 'qr_code_2', 'gradient_class' => 'grad-cyan', 'is_hot' => true, 'route_name' => null, 'order' => 15],
            ['title' => 'ইমেজ রিসাইজ', 'icon' => 'photo_size_select_large', 'gradient_class' => 'grad-blue', 'is_hot' => false, 'route_name' => null, 'order' => 16],
        ];

        foreach ($tools as $tool) {
            PdfTool::updateOrCreate(
                ['title' => $tool['title']],
                $tool
            );
        }
    }
}
