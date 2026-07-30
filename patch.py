import sys
import re

file_path = r'resources\views\pdf\tools_joint_photo.blade.php'
with open(file_path, 'r', encoding='utf-8') as f:
    content = f.read()

replacement = """        try {
            const useBgRemover = document.getElementById('remove-bg-checkbox').checked;

            if (!useBgRemover) {
                document.getElementById('loading-status-text').innerText = '??? ????? ??? ?????...';
                imgObj1 = await blobToImage(fileP1);
                document.getElementById('progress-bar').style.width = '50%';
                imgObj2 = await blobToImage(fileP2);
                document.getElementById('progress-bar').style.width = '100%';
            } else {
                document.getElementById('loading-status-text').innerText = '??? ????????? ??? ? ?? ???? ????????????? ????? ??? ?????...';
                
                const module = await import('https://esm.sh/@imgly/background-removal@1.4.5');
                const removeBg = module.default || module.removeBackground;
                if (!removeBg) throw new Error("??? ????????? ??? ??? ?????? ??????");

                const configP1 = {
                    publicPath: 'https://staticimgly.com/@imgly/background-removal-data/1.4.5/dist/',
                    progress: (key, current, total) => {
                        let percent = Math.round((current / total) * 45);
                        document.getElementById('progress-bar').style.width = percent + '%';
                    }
                };

                // Remove BG for Person 1
                const url1 = URL.createObjectURL(fileP1);
                let rawBlob1 = await removeBg(url1, configP1);
                let cleanBlob1 = await cleanEdges(rawBlob1);
                imgObj1 = await blobToImage(cleanBlob1);

                document.getElementById('progress-bar').style.width = '50%';
                document.getElementById('loading-status-text').innerText = '?? ???? ????????????? ????? ??? ?????...';

                // Remove BG for Person 2
                const configP2 = {
                    publicPath: 'https://staticimgly.com/@imgly/background-removal-data/1.4.5/dist/',
                    progress: (key, current, total) => {
                        let percent = 50 + Math.round((current / total) * 45);
                        document.getElementById('progress-bar').style.width = percent + '%';
                    }
                };
                const url2 = URL.createObjectURL(fileP2);
                let rawBlob2 = await removeBg(url2, configP2);
                let cleanBlob2 = await cleanEdges(rawBlob2);
                imgObj2 = await blobToImage(cleanBlob2);
            }

            document.getElementById('progress-bar').style.width = '100%';
            document.getElementById('loading-status-text').innerText = '??? ??????? ??????? ?????, ??????? ????...';"""

content = re.sub(r'try\s*\{.*?(?=setTimeout)', replacement + '\n\n            ', content, flags=re.DOTALL)

with open(file_path, 'w', encoding='utf-8') as f:
    f.write(content)

print('Updated JS successfully.')
