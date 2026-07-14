@extends('layouts.app')

@section('title', 'গ্রাফিক্স ডিজাইন এডিটর - সহজ কাজ')

@section('content')
<!-- Fabric.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/5.3.1/fabric.min.js"></script>
<!-- Bengali Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;600;700&family=Noto+Serif+Bengali:wght@400;700&display=swap" rel="stylesheet">

<style>
    .editor-container {
        display: flex;
        gap: 20px;
        max-width: 1400px;
        margin: 0 auto;
        padding: 20px;
    }
    .toolbox {
        width: 320px;
        flex-shrink: 0;
        display: flex;
        flex-direction: column;
        gap: 15px;
    }
    .canvas-area {
        flex: 1;
        display: flex;
        justify-content: center;
        align-items: center;
        background: #374151;
        border-radius: 12px;
        padding: 40px;
        box-shadow: inset 0 2px 8px rgba(0,0,0,0.5);
        overflow: auto;
    }
    .tool-section {
        background: rgba(255,255,255,0.05);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        padding: 15px;
    }
    .tool-title {
        font-weight: 600;
        margin-bottom: 10px;
        font-size: 0.95rem;
        color: var(--primary-color);
    }
</style>

<div class="editor-container">
    <!-- Toolbox -->
    <div class="toolbox">
        <div class="glass" style="padding: 20px;">
            <h3 style="margin-bottom: 20px; color: var(--primary-color);">ডিজাইন প্যানেল</h3>

            <!-- Templates -->
            <div class="tool-section mb-4">
                <div class="tool-title">ডিজাইন টেমপ্লেট</div>
                <button onclick="loadTemplate('fb-post')" class="btn" style="width: 100%; background: rgba(255,255,255,0.1); border: 1px solid var(--border-color); color: #fff; margin-bottom: 10px;">
                    ফেসবুক পোস্ট (বাংলা)
                </button>
            </div>

            <!-- Add Elements -->
            <div class="tool-section mb-4">
                <div class="tool-title">উপাদান যোগ করুন</div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                    <button onclick="addText()" class="btn" style="padding: 8px; font-size: 0.85rem; background: rgba(255,255,255,0.1); color: #fff;">+ টেক্সট</button>
                    <button onclick="addRect()" class="btn" style="padding: 8px; font-size: 0.85rem; background: rgba(255,255,255,0.1); color: #fff;">+ আয়তক্ষেত্র</button>
                </div>
            </div>

            <!-- Text Settings -->
            <div class="tool-section mb-4">
                <div class="tool-title">টেক্সট সেটিংস</div>
                <div class="form-group">
                    <label class="form-label" style="font-size: 0.8rem;">ফন্ট ফ্যামিলি</label>
                    <select id="fontFamily" class="form-control" onchange="changeFont()">
                        <option value="Hind Siliguri">Hind Siliguri (বাংলা)</option>
                        <option value="Noto Serif Bengali">Noto Serif Bengali (বাংলা)</option>
                        <option value="Arial">Arial</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label" style="font-size: 0.8rem;">রং (Color)</label>
                    <input type="color" id="textColor" class="form-control" style="height: 40px; padding: 5px;" onchange="changeColor()">
                </div>
            </div>

            <!-- Export -->
            <button onclick="downloadDesign()" class="btn btn-primary" style="width: 100%;">ডিজাইন ডাউনলোড করুন</button>
        </div>
    </div>

    <!-- Canvas -->
    <div class="canvas-area">
        <div>
            <canvas id="designCanvas"></canvas>
        </div>
    </div>
</div>

<script>
    var canvas;

    window.onload = function() {
        canvas = new fabric.Canvas('designCanvas', {
            width: 800,
            height: 600,
            backgroundColor: '#ffffff'
        });

        // Load Default template
        loadTemplate('fb-post');
    };

    function addText() {
        var text = new fabric.IText('এখানে লিখুন...', {
            left: 100,
            top: 100,
            fontFamily: 'Hind Siliguri',
            fill: '#000000',
            fontSize: 40
        });
        canvas.add(text);
        canvas.setActiveObject(text);
    }

    function addRect() {
        var rect = new fabric.Rect({
            left: 100,
            top: 250,
            fill: '#f59e0b',
            width: 200,
            height: 200
        });
        canvas.add(rect);
        canvas.setActiveObject(rect);
    }

    function changeColor() {
        var activeObject = canvas.getActiveObject();
        if (activeObject) {
            var color = document.getElementById('textColor').value;
            activeObject.set('fill', color);
            canvas.renderAll();
        }
    }

    function changeFont() {
        var activeObject = canvas.getActiveObject();
        if (activeObject && activeObject.type === 'i-text') {
            var font = document.getElementById('fontFamily').value;
            activeObject.set('fontFamily', font);
            canvas.renderAll();
        }
    }

    function loadTemplate(type) {
        canvas.clear();
        canvas.setBackgroundColor('#ffffff', canvas.renderAll.bind(canvas));

        if (type === 'fb-post') {
            canvas.setWidth(800);
            canvas.setHeight(800);

            // Add background rectangle
            var bg = new fabric.Rect({
                left: 0,
                top: 0,
                fill: '#0f172a',
                width: 800,
                height: 800,
                selectable: false
            });
            canvas.add(bg);

            // Add heading
            var title = new fabric.IText('বাংলা গ্রাফিক্স ডিজাইন\nসহজ কাজ অ্যাপে!', {
                left: 80,
                top: 200,
                fontFamily: 'Hind Siliguri',
                fill: '#f59e0b',
                fontSize: 60,
                fontWeight: 'bold',
                lineHeight: 1.3
            });
            canvas.add(title);

            // Add subtext
            var subtitle = new fabric.IText('আপনার ফেসবুক পোস্ট ডিজাইন করুন সেকেন্ডে', {
                left: 80,
                top: 400,
                fontFamily: 'Noto Serif Bengali',
                fill: '#ffffff',
                fontSize: 28
            });
            canvas.add(subtitle);
        }
    }

    function downloadDesign() {
        var dataURL = canvas.toDataURL({
            format: 'png',
            quality: 1.0
        });
        var link = document.createElement('a');
        link.download = 'sohozkaj_design.png';
        link.href = dataURL;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
</script>
@endsection
