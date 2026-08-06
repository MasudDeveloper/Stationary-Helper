import sys
import re

file_path = r'resources\views\questions\create.blade.php'
with open(file_path, 'r', encoding='utf-8') as f:
    content = f.read()

# 1. MathJax Config
mathjax_old = r'<script src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>'
mathjax_new = r'''<script>
        MathJax = {
            tex: {
                inlineMath: [['$', '$'], ['\\(', '\\)']]
            }
        };
    </script>
    <script src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>'''
content = content.replace(mathjax_old, mathjax_new)

# 2. Include question_tools_buttons
tools_old = r'<div id="editor-fields">'
tools_new = r'''@include('partials.question_tools_buttons')

            <div id="editor-fields">'''
if "@include('partials.question_tools_buttons')" not in content:
    content = content.replace(tools_old, tools_new)

# 3. Include question_modals before </body>
if "@include('partials.question_modals')" not in content:
    content = content.replace('</body>', "@include('partials.question_modals')\n</body>")

with open(file_path, 'w', encoding='utf-8') as f:
    f.write(content)

print('Updated create.blade.php successfully.')
