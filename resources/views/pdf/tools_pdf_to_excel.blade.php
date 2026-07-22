@extends('layouts.app')

@section('title', 'পিডিএফ টু এক্সেল - Smart Stationary')

@section('content')
<!-- PDF.js CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.min.js"></script>
<script>
    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.worker.min.js';
</script>

<style>
    .tool-header { text-align: center; margin-bottom: 30px; }
</style>

<div class="container" style="padding: 40px 20px; max-width: 800px;">
    <div class="tool-header">
        <div class="tool-squircle grad-red" style="width: 80px; height: 80px; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center; border-radius: 20px; box-shadow: 0 10px 20px rgba(220, 38, 38, 0.3);">
            <i class="material-icons-round" style="font-size: 2.5rem; color: #fff;">table_view</i>
        </div>
        <h2 style="color: #fff; font-size: 1.8rem; font-weight: 700;">পিডিএফ টু এক্সেল (PDF to Excel / CSV)</h2>
        <p style="color: var(--text-muted); margin-top: 10px;">পিডিএফ ফাইলে থাকা টেবিল এবং টেক্সট এক্সট্রাক্ট করে এক্সেল সাপোর্টেড ফাইলে (CSV) ডাউনলোড করুন।</p>
    </div>

    <div class="glass" style="padding: 40px;">
        <div class="form-group" style="margin-bottom: 30px;">
            <label class="form-label">পিডিএফ ফাইল নির্বাচন করুন</label>
            <input type="file" id="pdf-upload" class="form-control" accept="application/pdf">
        </div>

        <div id="loading" style="display: none; color: var(--primary-color); margin: 20px 0; text-align: center; font-weight: bold;">
            ডেটা এক্সট্রাক্ট করা হচ্ছে... দয়া করে অপেক্ষা করুন।
        </div>

        <button id="process-btn" class="btn btn-primary" onclick="convertToExcel()" style="width: 100%; padding: 15px; font-size: 1.1rem;">
            <i class="material-icons-round">file_download</i> এক্সেলে কনভার্ট করুন ও ডাউনলোড করুন
        </button>
    </div>
</div>

<script>
    async function convertToExcel() {
        const fileInput = document.getElementById('pdf-upload');
        const file = fileInput.files[0];

        if (!file) {
            Swal.fire('অনুগ্রহ করে একটি পিডিএফ ফাইল নির্বাচন করুন।');
            return;
        }

        document.getElementById('loading').style.display = 'block';
        document.getElementById('process-btn').style.display = 'none';

        try {
            const arrayBuffer = await file.arrayBuffer();
            const pdf = await pdfjsLib.getDocument({ data: arrayBuffer }).promise;
            const totalPages = pdf.numPages;

            let csvContent = "\uFEFF"; // BOM for UTF-8 Excel support

            for (let i = 1; i <= totalPages; i++) {
                const page = await pdf.getPage(i);
                const textContent = await page.getTextContent();
                
                // Group text items by Y coordinate (rows)
                const rows = {};
                const ROW_TOLERANCE = 5; // Combine texts on roughly the same line

                textContent.items.forEach(item => {
                    if (!item.str.trim()) return;
                    
                    const x = item.transform[4];
                    const y = Math.round(item.transform[5]);
                    
                    // Find an existing row within tolerance
                    let matchedY = Object.keys(rows).find(key => Math.abs(key - y) <= ROW_TOLERANCE);
                    if (!matchedY) {
                        matchedY = y;
                        rows[matchedY] = [];
                    }
                    
                    rows[matchedY].push({ text: item.str.trim(), x: x });
                });

                // Sort rows top to bottom (highest Y usually means top in PDF, but sometimes opposite, let's sort descending Y for standard PDF coord system)
                const sortedY = Object.keys(rows).map(Number).sort((a, b) => b - a);

                sortedY.forEach(y => {
                    // Sort items in row left to right
                    const rowItems = rows[y].sort((a, b) => a.x - b.x);
                    
                    const rowCsv = rowItems.map(item => {
                        // Escape quotes and wrap in quotes to handle commas inside text
                        const text = item.text.replace(/"/g, '""');
                        return `"${text}"`;
                    }).join(",");
                    
                    csvContent += rowCsv + "\r\n";
                });
                
                // Add page break separator
                csvContent += "\r\n";
            }

            // Download CSV
            const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            const link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = 'Converted_Data.csv';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);

            Swal.fire('সফলভাবে কনভার্ট করা হয়েছে! ফাইলটি এক্সেল দিয়ে ওপেন করুন।');

        } catch (error) {
            console.error(error);
            Swal.fire('পিডিএফ কনভার্ট করতে সমস্যা হয়েছে!');
        } finally {
            document.getElementById('loading').style.display = 'none';
            document.getElementById('process-btn').style.display = 'inline-block';
        }
    }
</script>
@endsection
