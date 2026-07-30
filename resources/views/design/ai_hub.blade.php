@extends('layouts.app')

@section('title', 'এআই সার্ভিস হাব - সহজ কাজ')

@section('content')
<div class="container" style="margin-top: 40px; margin-bottom: 40px;">
    <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 25px; border-bottom: 1px solid var(--border-color); padding-bottom: 15px;">
        <div>
            <h2 style="color: #fff; font-size: 1.8rem; font-weight: 700; border-left: 4px solid #818cf8; padding-left: 12px; margin-bottom: 8px;">এআই সার্ভিস হাব (AI Service Hub)</h2>
            <p style="color: var(--text-muted); font-size: 0.95rem; margin: 0;">কৃত্রিম বুদ্ধিমত্তা সম্পন্ন টুলস ব্যবহার করে আপনার কাজকে সহজ করুন</p>
        </div>
    </div>

    <!-- Pricing Alert Info -->
    <div class="glass" style="padding: 15px 25px; margin-bottom: 30px; border-radius: 12px; border-left: 5px solid #818cf8; display: flex; justify-content: space-between; align-items: center; font-weight: 500;">
        <div style="color: #e2e8f0;">
            <i class="material-icons-round" style="vertical-align: middle; color: #818cf8; margin-right: 5px;">info</i>
            <span style="color: #fff; font-weight: 600;">ক্রেডিট রেট:</span> পাবলিক অ্যাকাউন্ট (৫ ক্রেডিট/ছবি), বিজনেস অ্যাকাউন্ট (১ ক্রেডিট/ছবি)।
        </div>
        <div style="background: rgba(99, 102, 241, 0.1); padding: 8px 15px; border-radius: 8px; border: 1px solid rgba(99, 102, 241, 0.2);">
            <strong style="color: #cbd5e1;">আপনার ব্যালেন্স:</strong> <span style="color: #818cf8; font-weight: 800; font-size: 1.1rem;">৳<span id="credit-balance">{{ Auth::user()->credits }}</span></span>
        </div>
    </div>

    <div style="display: flex; gap: 30px; flex-wrap: wrap;">
        
        <!-- AI Image Generator -->
        <div class="glass" style="flex: 1; min-width: 350px; padding: 30px; border-radius: 15px;">
            <div style="display: flex; align-items: center; margin-bottom: 20px; gap: 15px;">
                <div style="background: linear-gradient(135deg, #a855f7, #ec4899); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                    <i class="material-icons-round" style="font-size: 2.5rem;">auto_awesome</i>
                </div>
                <div>
                    <h3 style="margin: 0; color: #fff; font-weight: 700;">১. এআই ইমেজ জেনারেটর</h3>
                    <p style="font-size: 0.9rem; color: var(--text-muted); margin: 5px 0 0 0;">আপনার মনের কল্পনা লিখে ছবি তৈরি করুন</p>
                </div>
            </div>
            
            <div class="form-group" style="margin-bottom: 20px;">
                <label class="form-label" style="font-weight: 600; font-size: 1rem;">ইমেজ প্রম্পট লিখুন (ইংরেজিতে)</label>
                <textarea id="image-prompt" class="form-control" rows="4" placeholder="Describe the image you want in detail...&#10;Example: A futuristic cyberpunk city at night with neon lights and flying cars, highly detailed, 8k resolution" style="background: rgba(255,255,255,0.03); border-color: rgba(255,255,255,0.1); resize: none;"></textarea>
                
                <!-- Instructions -->
                <div style="background: rgba(168, 85, 247, 0.1); border-left: 3px solid #a855f7; padding: 12px; margin-top: 15px; border-radius: 4px; font-size: 0.85rem; color: #e2e8f0;">
                    <strong style="color: #c084fc;">ভালো ছবি পাওয়ার কিছু টিপস:</strong>
                    <ul style="margin: 5px 0 0 0; padding-left: 20px; line-height: 1.6;">
                        <li>কী চান তা <b>ইংরেজিতে</b> বিস্তারিত লিখুন (Subject, Action, Background)।</li>
                        <li>ছবিতে কী ধরনের কালার বা লাইটিং চান তা উল্লেখ করুন (e.g., cinematic lighting, neon lights)।</li>
                        <li>স্টাইল বলে দিন (e.g., photorealistic, 3d render, anime style, oil painting)।</li>
                        <li>কোয়ালিটি ওয়ার্ড ব্যবহার করুন (e.g., highly detailed, 4k, masterpiece)।</li>
                    </ul>
                </div>
            </div>
            
            @php
                $aiCostSetting = \App\Models\Setting::where('key', 'ai_image_cost')->value('value');
                $aiCostVal = ($aiCostSetting !== null && $aiCostSetting !== '') ? (float) $aiCostSetting : 0;
            @endphp
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; padding: 0 5px;">
                <span style="font-size: 0.85rem; color: var(--text-muted);">AI মডেল: Pollinations AI (Unlimited)</span>
                @if ($aiCostVal == 0)
                    <span style="font-size: 0.85rem; color: #10b981; font-weight: 600; background: rgba(16, 185, 129, 0.1); padding: 4px 10px; border-radius: 12px; border: 1px solid rgba(16, 185, 129, 0.3);">
                        <i class="material-icons-round" style="font-size: 1rem; vertical-align: middle; margin-right: 2px;">check_circle</i> সম্পূর্ণ ফ্রি (0 Credit)
                    </span>
                @else
                    <span style="font-size: 0.85rem; color: #f59e0b; font-weight: 600; background: rgba(245, 158, 11, 0.1); padding: 4px 10px; border-radius: 12px; border: 1px solid rgba(245, 158, 11, 0.3);">
                        <i class="material-icons-round" style="font-size: 1rem; vertical-align: middle; margin-right: 2px;">monetization_on</i> খরচ: {{ $aiCostVal }} ক্রেডিট / ছবি
                    </span>
                @endif
            </div>

            <button onclick="generateImage()" id="btn-generate" class="btn" style="width: 100%; font-weight: 600; padding: 12px; background: linear-gradient(135deg, #a855f7, #ec4899); color: #fff; border: none; box-shadow: 0 4px 15px rgba(168, 85, 247, 0.3);">ইমেজ জেনারেট করুন</button>

            <!-- Result Area -->
            <div id="gen-result-container" style="margin-top: 25px; text-align: center; display: none;">
                <h5 style="margin-bottom: 10px;">জেনারেট করা ছবি:</h5>
                <img id="gen-image" src="" alt="AI Output" style="width: 100%; border-radius: 8px; border: 1px solid var(--border-color); max-width: 300px;">
                <br>
                <a id="gen-download" href="" download="ai_image.png" class="btn" style="margin-top: 15px; background: #10b981; color: #fff; padding: 8px 16px; font-size: 0.9rem;">ডাউনলোড করুন</a>
            </div>
            <!-- Loading Spinner -->
            <div id="gen-loader" style="margin-top: 25px; text-align: center; display: none;">
                <div style="border: 4px solid rgba(255,255,255,0.1); border-top: 4px solid var(--primary-color); border-radius: 50%; width: 40px; height: 40px; animation: spin 1s linear infinite; margin: 0 auto;"></div>
                <p style="margin-top: 10px; font-size: 0.9rem;">ছবি তৈরি হচ্ছে, অনুগ্রহ করে অপেক্ষা করুন...</p>
            </div>
        </div>

        <!-- AI Background Remover -->
        <div class="glass" style="flex: 1; min-width: 350px; padding: 30px; border-radius: 15px;">
            <div style="display: flex; align-items: center; margin-bottom: 20px; gap: 15px;">
                <div style="background: linear-gradient(135deg, #06b6d4, #3b82f6); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                    <i class="material-icons-round" style="font-size: 2.5rem;">layers_clear</i>
                </div>
                <div>
                    <h3 style="margin: 0; color: #fff; font-weight: 700;">২. ব্যাকগ্রাউন্ড রিমুভার <span style="background: #10b981; color: #fff; font-size: 0.75rem; padding: 2px 8px; border-radius: 20px; vertical-align: middle; margin-left: 5px; font-weight: 600;">সম্পূর্ণ ফ্রি</span></h3>
                    <p style="font-size: 0.9rem; color: var(--text-muted); margin: 5px 0 0 0;">আপনার ছবির ব্যাকগ্রাউন্ড স্বয়ংক্রিয়ভাবে মুছে ফেলুন (কোনো ক্রেডিট কাটা হবে না)</p>
                </div>
            </div>
            
            <div class="form-group">
                <label class="form-label" style="font-weight: 500;">ছবি আপলোড করুন</label>
                <input type="file" id="bg-image-input" class="form-control" accept="image/*" onchange="previewBgImage()" style="background: rgba(255,255,255,0.03); border-color: rgba(255,255,255,0.1); padding: 10px;">
            </div>

            <!-- Preview/Upload Area -->
            <div id="bg-preview-container" style="margin-top: 15px; text-align: center; display: none; background: rgba(0,0,0,0.2); padding: 15px; border-radius: 12px;">
                <img id="bg-preview-img" src="" alt="Uploaded" style="max-width: 150px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.1);">
            </div>
            
            <button onclick="removeBackground()" id="btn-bg-remove" class="btn" style="width: 100%; margin-top: 15px; font-weight: 600; padding: 12px; background: linear-gradient(135deg, #10b981, #059669); color: #fff; border: none; box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);" disabled><i class="material-icons-round" style="vertical-align: middle; margin-right: 5px;">auto_awesome</i> ব্যাকগ্রাউন্ড রিমুভ করুন (সম্পূর্ণ ফ্রি)</button>

            <!-- Result Area -->
            <div id="bg-result-container" style="margin-top: 25px; text-align: center; display: none;">
                <h5 style="margin-bottom: 10px;">ফলাফল (স্বচ্ছ ব্যাকগ্রাউন্ড):</h5>
                <div style="background-image: radial-gradient(#e5e7eb 20%, transparent 20%), radial-gradient(#e5e7eb 20%, transparent 20%); background-size: 10px 10px; background-position: 0 0, 5px 5px; padding: 10px; border-radius: 8px; display: inline-block;">
                    <canvas id="bg-result-canvas" style="max-width: 250px; display: block;"></canvas>
                </div>
                <br>
                <button onclick="downloadBgRemoved()" class="btn" style="margin-top: 15px; background: #10b981; color: #fff; padding: 8px 16px; font-size: 0.9rem;">ডাউনলোড পিএনজি</button>
            </div>
            
            <!-- Loading Spinner -->
            <div id="bg-loader" style="margin-top: 25px; text-align: center; display: none;">
                <div style="border: 4px solid rgba(255,255,255,0.1); border-top: 4px solid var(--primary-color); border-radius: 50%; width: 40px; height: 40px; animation: spin 1s linear infinite; margin: 0 auto;"></div>
                <p style="margin-top: 10px; font-size: 0.9rem;">ব্যাকগ্রাউন্ড রিমুভ হচ্ছে...</p>
            </div>
        </div>

    </div>
</div>

<style>
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>

<script>
    // Image Generation AJAX
    function generateImage() {
        const prompt = document.getElementById('image-prompt').value;
        if (!prompt) {
            Swal.fire('অনুগ্রহ করে প্রম্পট দিন।');
            return;
        }

        let cost = {{ $cost ?? 0 }};
        if (cost > 0) {
            Swal.fire({
                title: 'নিশ্চিত করুন',
                text: `এই ছবিটি তৈরি করতে আপনার একাউন্ট থেকে ${cost} ক্রেডিট কাটা হবে। আপনি কি রাজি?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3b82f6',
                cancelButtonColor: '#ef4444',
                confirmButtonText: 'হ্যাঁ, তৈরি করুন',
                cancelButtonText: 'না, বাতিল করুন'
            }).then((result) => {
                if (result.isConfirmed) {
                    executeGenerate(prompt);
                }
            });
        } else {
            executeGenerate(prompt);
        }
    }

    function executeGenerate(prompt) {
        document.getElementById('gen-loader').style.display = 'block';
        document.getElementById('gen-result-container').style.display = 'none';
        document.getElementById('btn-generate').disabled = true;

        fetch('{{ route("design.ai_hub.generate") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ prompt: prompt })
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('gen-loader').style.display = 'none';
            document.getElementById('btn-generate').disabled = false;

            if (data.error) {
                Swal.fire(data.error);
            } else {
                // Show Image
                const genImg = document.getElementById('gen-image');
                genImg.src = data.image_url;
                document.getElementById('gen-download').href = data.image_url;
                document.getElementById('gen-result-container').style.display = 'block';
                
                // Update Balance
                document.getElementById('credit-balance').innerText = data.remaining_credits;
            }
        })
        .catch(err => {
            document.getElementById('gen-loader').style.display = 'none';
            document.getElementById('btn-generate').disabled = false;
            Swal.fire('জেনারেট করার সময় ত্রুটি ঘটেছে।');
        });
    }

    // BG Remover logic
    let uploadedImageBase64 = "";

    function previewBgImage() {
        const fileInput = document.getElementById('bg-image-input');
        const file = fileInput.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('bg-preview-img').src = e.target.result;
                document.getElementById('bg-preview-container').style.display = 'block';
                document.getElementById('btn-bg-remove').disabled = false;
                uploadedImageBase64 = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    }

    async function removeBackground() {
        if (!uploadedImageBase64) return;

        let bgCost = {{ $bg_cost ?? 0 }};
        if (bgCost > 0) {
            Swal.fire({
                title: 'নিশ্চিত করুন',
                text: `এই ছবির ব্যাকগ্রাউন্ড রিমুভ করতে আপনার একাউন্ট থেকে ${bgCost} ক্রেডিট কাটা হবে। আপনি কি রাজি?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3b82f6',
                cancelButtonColor: '#ef4444',
                confirmButtonText: 'হ্যাঁ, রিমুভ করুন',
                cancelButtonText: 'না, বাতিল করুন'
            }).then((result) => {
                if (result.isConfirmed) {
                    executeBgRemove();
                }
            });
        } else {
            executeBgRemove();
        }
    }

    async function executeBgRemove() {
        document.getElementById('bg-loader').style.display = 'block';
        document.getElementById('bg-result-container').style.display = 'none';
        document.getElementById('btn-bg-remove').disabled = true;

        try {
            // Deduct Credit via DB Request first
            const res = await fetch('{{ route("design.ai_hub.bg_remove") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ image: uploadedImageBase64 })
            });
            const data = await res.json();
            if (data.error) {
                document.getElementById('bg-loader').style.display = 'none';
                document.getElementById('btn-bg-remove').disabled = false;
                Swal.fire(data.error);
                return;
            }

            // Update Balance
            document.getElementById('credit-balance').innerText = data.remaining_credits;

            // Execute client-side AI Background Removal using @imgly/background-removal
            const module = await import('https://esm.sh/@imgly/background-removal@1.4.5');
            const removeBg = module.default || module.removeBackground;
            if (!removeBg) throw new Error("এআই লাইব্রেরি লোড হতে ব্যর্থ হয়েছে।");

            const config = {
                publicPath: 'https://staticimgly.com/@imgly/background-removal-data/1.4.5/dist/'
            };

            let rawBlob = await removeBg(uploadedImageBase64, config);
            let cleanBlob = await cleanEdges(rawBlob);
            let transparentUrl = URL.createObjectURL(cleanBlob);

            const img = new Image();
            img.onload = function() {
                const canvas = document.getElementById('bg-result-canvas');
                const ctx = canvas.getContext('2d');
                canvas.width = img.width;
                canvas.height = img.height;
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                ctx.drawImage(img, 0, 0);

                document.getElementById('bg-loader').style.display = 'none';
                document.getElementById('btn-bg-remove').disabled = false;
                document.getElementById('bg-result-container').style.display = 'block';
            };
            img.src = transparentUrl;

        } catch (err) {
            console.error(err);
            document.getElementById('bg-loader').style.display = 'none';
            document.getElementById('btn-bg-remove').disabled = false;
            Swal.fire('ব্যাকগ্রাউন্ড রিমুভ করার সময় ত্রুটি ঘটেছে: ' + (err.message || ''));
        }
    }

    function cleanEdges(blob) {
        return new Promise((resolve) => {
            const img = new Image();
            img.onload = () => {
                const canvas = document.createElement('canvas');
                canvas.width = img.width;
                canvas.height = img.height;
                const ctx = canvas.getContext('2d');
                ctx.drawImage(img, 0, 0);
                
                const imgData = ctx.getImageData(0, 0, canvas.width, canvas.height);
                const data = imgData.data;
                const width = canvas.width;
                const height = canvas.height;
                
                for (let y = 0; y < height; y++) {
                    for (let x = 0; x < width; x++) {
                        let idx = (y * width + x) * 4;
                        let alpha = data[idx + 3];
                        
                        if (alpha > 10) {
                            let isEdge = false;
                            const offsets = [
                                [-2,0], [2,0], [0,-2], [0,2],
                                [-1,-1], [1,-1], [-1,1], [1,1]
                            ];
                            for(let i=0; i<offsets.length; i++) {
                                let nx = x + offsets[i][0];
                                let ny = y + offsets[i][1];
                                if(nx >= 0 && nx < width && ny >= 0 && ny < height) {
                                    if(data[(ny * width + nx) * 4 + 3] < 20) {
                                        isEdge = true;
                                        break;
                                    }
                                } else {
                                    isEdge = true;
                                    break;
                                }
                            }
                            
                            if (isEdge && alpha < 240) {
                                data[idx + 3] = Math.max(0, alpha - 80);
                                data[idx] = Math.max(0, data[idx] - 40);
                                data[idx + 1] = Math.max(0, data[idx + 1] - 40);
                                data[idx + 2] = Math.max(0, data[idx + 2] - 40);
                            }
                        }
                    }
                }
                ctx.putImageData(imgData, 0, 0);
                canvas.toBlob(resolve, 'image/png');
            };
            img.src = URL.createObjectURL(blob);
        });
    }

    function downloadBgRemoved() {
        const canvas = document.getElementById('bg-result-canvas');
        const link = document.createElement('a');
        link.download = 'bg_removed.png';
        link.href = canvas.toDataURL('image/png');
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
</script>
@endsection

