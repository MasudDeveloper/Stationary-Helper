<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CvTemplate;

class CvTemplateSeeder extends Seeder
{
    public function run(): void
    {
        $htmlContent = <<<'HTML'
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Arial', 'Helvetica', sans-serif;
        }

        body {
            background-color: #ffffff;
            color: #333;
            font-size: 13px;
            line-height: 1.5;
        }

        .cv-container {
            width: 210mm;
            min-height: 297mm;
            max-height: 297mm;
            margin: 0 auto;
            background: #ffffff;
            display: table;
            table-layout: fixed;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        /* Left Sidebar */
        .sidebar {
            width: 32%;
            background-color: #b9d3ee;
            padding: 22px 18px;
            display: table-cell;
            vertical-align: top;
        }

        .profile-title {
            color: #1a237e;
            font-size: 22px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 20px;
            line-height: 1.2;
        }

        .profile-img-container {
            width: 135px;
            height: 155px;
            margin: 0 auto 20px auto;
            background-color: #ffffff;
            border: 4px solid #d0d0d0;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .profile-img-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .sidebar-section {
            margin-bottom: 18px;
        }

        .sidebar-heading {
            font-size: 15px;
            font-weight: bold;
            color: #1a237e;
            border-bottom: 1.5px solid #1a237e;
            padding-bottom: 3px;
            margin-bottom: 8px;
        }

        .sidebar-content {
            font-size: 12px;
            color: #222;
        }

        .sidebar-content p {
            margin-bottom: 4px;
        }

        .sidebar-list {
            list-style-type: disc;
            padding-left: 18px;
        }

        .sidebar-list li {
            margin-bottom: 3px;
        }

        .signature-area {
            margin-top: 35px;
            font-size: 12px;
        }

        .signature-line {
            border-top: 1px solid #333;
            width: 120px;
            margin-bottom: 4px;
        }

        /* Right Content Area */
        .main-content {
            width: 68%;
            padding: 22px 22px;
            display: table-cell;
            vertical-align: top;
            background-color: #ffffff;
        }

        .section {
            margin-bottom: 14px;
        }

        .section-title {
            font-size: 15px;
            font-weight: bold;
            color: #0d47a1;
            border-bottom: 1.5px solid #0d47a1;
            padding-bottom: 3px;
            margin-bottom: 6px;
        }

        .text-justify {
            text-align: justify;
        }

        /* Grid for Skills */
        .skills-grid {
            width: 100%;
        }

        .skills-grid td {
            width: 50%;
            vertical-align: top;
        }

        .skills-list {
            list-style-type: disc;
            padding-left: 18px;
        }

        .skills-list li {
            margin-bottom: 4px;
        }

        /* Experience List */
        .exp-list {
            list-style: none;
        }

        .exp-list li {
            margin-bottom: 6px;
            position: relative;
            padding-left: 0;
        }

        /* Tables for Education & Info */
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 6px;
        }

        .info-table td {
            padding: 1.5px 4px;
            vertical-align: top;
        }

        .info-table td.label {
            width: 130px;
            font-weight: 500;
        }

        .info-table td.colon {
            width: 15px;
        }

    </style>
</head>
<body>

<div class="cv-container">
    <!-- Left Sidebar -->
    <div class="sidebar">
        <h1 class="profile-title">[Name]</h1>
        
        <div class="profile-img-container">
            <img src="[Photo]" alt="Profile Photo">
        </div>

        <div class="sidebar-section">
            <h2 class="sidebar-heading">Contact</h2>
            <div class="sidebar-content">
                <p><strong>Present Address:</strong></p>
                <p>[Present_Address]</p>
                <br>
                <p><strong>Phone:</strong></p>
                <p>[Phone]</p>
                <br>
                <p><strong>Email:</strong></p>
                <p>[Email]</p>
            </div>
        </div>

        <div class="sidebar-section">
            <h2 class="sidebar-heading">Languages</h2>
            <div class="sidebar-content">
                <p>[Languages]</p>
            </div>
        </div>

        <div class="sidebar-section">
            <h2 class="sidebar-heading">Hobbies</h2>
            <div class="sidebar-content">
                <ul class="sidebar-list">
                    [Hobbies_List]
                </ul>
            </div>
        </div>

        <div class="signature-area">
            <div class="signature-line"></div>
            <p>Signature</p>
            <p>Date: [Date]</p>
        </div>
    </div>

    <!-- Right Main Content -->
    <div class="main-content">
        
        <!-- Career Objective -->
        <div class="section">
            <h2 class="section-title">Career Objective</h2>
            <p class="text-justify">[Career_Objective]</p>
        </div>

        <!-- Skill Highlights -->
        <div class="section">
            <h2 class="section-title">Skill Highlights</h2>
            <table class="skills-grid">
                <tr>
                    <td>
                        <ul class="skills-list">
                            [Skills_Left]
                        </ul>
                    </td>
                    <td>
                        <ul class="skills-list">
                            [Skills_Right]
                        </ul>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Experience -->
        <div class="section">
            <h2 class="section-title">Experience</h2>
            <ul class="exp-list">
                [Experience_List]
            </ul>
        </div>

        <!-- Education -->
        <div class="section">
            <h2 class="section-title">Education</h2>
            [Education_Details]
        </div>

        <!-- Extra Qualification -->
        <div class="section">
            <h2 class="section-title">Extra Qualification</h2>
            <ul class="skills-list">
                [Extra_Qualifications]
            </ul>
        </div>

        <!-- Personal Information -->
        <div class="section">
            <h2 class="section-title">Personal Information</h2>
            <table class="info-table">
                <tr>
                    <td class="label">Father's Name</td>
                    <td class="colon">:</td>
                    <td>[Fathers_Name]</td>
                </tr>
                <tr>
                    <td class="label">Mother's Name</td>
                    <td class="colon">:</td>
                    <td>[Mothers_Name]</td>
                </tr>
                <tr>
                    <td class="label">Date of Birth</td>
                    <td class="colon">:</td>
                    <td>[Date_of_Birth]</td>
                </tr>
                <tr>
                    <td class="label">Permanent Address</td>
                    <td class="colon">:</td>
                    <td>[Permanent_Address]</td>
                </tr>
                <tr>
                    <td class="label">Religion</td>
                    <td class="colon">:</td>
                    <td>[Religion]</td>
                </tr>
                <tr>
                    <td class="label">Nationality</td>
                    <td class="colon">:</td>
                    <td>[Nationality]</td>
                </tr>
            </table>
        </div>

    </div>
</div>

</body>
</html>
HTML;

        preg_match_all('/\[(.*?)\]/', $htmlContent, $matches);
        $fields = array_values(array_unique($matches[1]));

        CvTemplate::updateOrCreate(
            ['name' => 'Professional 1-Page CV (Modern Blue)'],
            [
                'language' => 'en',
                'format' => '1-Page',
                'design_name' => 'Modern Blue Sidebar',
                'content' => $htmlContent,
                'total_fields' => count($fields),
                'fields_data' => json_encode($fields),
                'credit_cost' => 5,
                'is_active' => true,
            ]
        );
    }
}
