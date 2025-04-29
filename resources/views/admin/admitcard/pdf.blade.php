<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Hall Ticket</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.5;
        }
        @page {
            size: A4; /* Ensures proper PDF page size */
            margin: 20px 10px 40px 10px; /* Increased bottom margin to 40px */
        }
        body {
            margin: 0;
            padding: 0;
        }
        .container {
            width: 90%;
            margin: auto;
            border: 2px solid black;
            padding: 20px;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            min-height: calc(100vh - 80px); /* Ensures enough height for spacing */
            padding-bottom: 20px; /* Adds space inside the border */
            margin-bottom: 20px; /* Ensures 20px gap before page end */
            page-break-inside: avoid; /* Prevents breaking inside the container */
        }
        .page-break {
            page-break-before: always; /* Ensures a new page starts */
        }
        .translucent-red {
            background-color: rgba(255, 0, 0, 0.15); /* Light translucent red */
            padding: 5px;
            font-weight: bold;
        }
        .header {
            text-align: center;
            font-size: 13px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 10px;
        }
        .sub-header {
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            color: red;
        }
        .gray-box {
            background-color: lightgray;
            padding: 10px;
            font-weight: bold;
            text-align: center;
        }
        .details-table {
            width: 100%;
            border-collapse: collapse;
        }
        .details-table td, .details-table th {
            border: 1px solid black;
            padding: 8px;
        }
        .section {
            margin-top: 5px;
            page-break-inside: avoid; /* Prevents the box from splitting */
        }
        .section-title {
            font-weight: bold;
            margin-top: 5px;
            text-decoration: underline;
            font-size: 13px;
        }
        .content {
            margin-top: 5px;
            text-align: justify;
            page-break-inside: avoid; /* Ensures list content does not break */
        }
        li {
            margin-bottom: 5px;
        }
        .bold {
            font-weight: bold;
        }
        .signature-box {
            border: 2px solid black;
            width: 250px;
            height: 40px; /* Adjust as needed */
            display: flex; /* Enables flexbox */
            align-items: center; /* Centers content vertically */
            justify-content: center; /* Centers content horizontally */
            text-align: center;
            margin: 20px auto 0;
            font-weight: bold; /* Optional: Makes text more prominent */
            margin-top: 350px;
        }
        .footer {
            text-align: center;
            font-size: 10px;
            margin-top: 5px;
            font-weight: bold;
        }
    </style>
    
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">EXAM (27 MARCH, 2025 - 27 APRIL, 2025)</div>
        <table class="details-table" style="margin-top:20px;">
            <tr>
                <td class="translucent-red"><b>Candidate Name:</b></td>
                <td>{{ $student->name }}</td>
                <td class="translucent-red"><b>Roll No:</b></td>
                <td>{{ $student->id }}</td>
            </tr>
            <tr>
                <td class="translucent-red"><b>Date of Birth:</b></td>
                <td>{{ $student->dob }}</td>
                <td class="translucent-red"><b>Seating Number:</b></td>
                <td>{{ $student->id }}</td>
            </tr>
            <tr>
                <td class="translucent-red"><b>Venue:</b></td>
                <td colspan="3">{{ $student->school_name }}</td>
            </tr>
        </table>

        <div class="section-title">Exam Schedule :</div>
        <table class="details-table" style="margin-top:20px;">
            <tr>
                <th>Exam</th>
                <th>Subjects</th>
                <th>Exam Date</th>
                <th>Exam Timing</th>
            </tr>
            @foreach($exams as $data)
                <tr>
                    <td>{{ $data['exam_name'] }}</td> <!-- Fix the key name -->
                    <td>{{ $data['subject'] }}</td>
                    <td>{{ $data['date'] }}</td>
                    <td>{{ $data['time'] }}</td>
                </tr>
            @endforeach
        </table>

        <div class="sub-header" style="margin-top:20px;">General Instructions for Candidates</div>
        <div class="gray-box" style="margin-top:20px;">The total duration of the examination is 180 minutes.<br>
            Candidates will be permitted to leave the examination hall only after 10:30 am, on a need basis.
        </div>

        <!-- Hall Ticket & Exam Details -->
        <div class="section-title">Hall ticket and Entry :</div>
        <div class="content">
            <ul>
                <li>The Hall Ticket must be presented for verification along with one original photo identification (not photocopy or scanned copy). Examples of acceptable photo identification documents are School ID, College ID, Employee ID, Driving License, Passport, PAN card, Voter ID, and Aadhaar-ID. A printed copy of the hall ticket and original photo ID card should be brought to the exam centre. Hall ticket and ID card copies on the phone will not be permitted.</li>
                <li>This Hall Ticket is valid only if the candidate's photograph and signature images are legible. To ensure this, print the Hall Ticket on A4-sized paper using a laser printer, preferably a color photo printer.</li>
                <li><strong>TIMELINE:</strong> 
                    <ul>
                        <li>8:00 am - Report to the examination venue</li>
                        <li>8:40 am - Candidates permitted to occupy allotted seats</li>
                        <li>8:50 am - Candidates login and read instructions</li>
                        <li>9:00 am - Exam starts</li>
                        <li>9:30 am - Gate closes, no entry beyond this time</li>
                        <li>10:30 am - Submit button enabled</li>
                        <li>12:00 pm - Exam ends</li>
                    </ul>
                </li>
                <li>Candidates will be permitted to appear for the examination ONLY after their credentials are verified by center officials. Candidates are advised to locate the examination center at least a day prior to the examination, so that they can reach the center on time for the examination.</li>
            </ul>
        </div>

        <!-- Permitted & Not Permitted Items -->
        <div class="section-title">Permitted :</div>
        <div class="content">
            <ul>
                <li>You may bring vehicle keys inside the exam hall.</li>
                <li>You are advised to carry your own drinking water in a transparent bottle.</li>
                <li>Candidates are allowed to bring sanitizer in a small transparent bottle.</li>
            </ul>
        </div>
    </div>
        <!-- Force a new page -->
        <div class="page-break"></div>

    <div class="container">  
        <div class="section-title">Not Permitted :</div>
        <div class="content">
            <ul>
                <li>Watches, wallets, mobile phones, Bluetooth devices, microphones, pagers, health bands or any other electronic gadgets, any printed/blank/handwritten paper, log tables, writing pads, scales, geometry/pencil-boxes, pouches, calculators, pen drives, electronic pens, handbags, goggles, electronic vehicle keys or similar such items are NOT allowed inside the examination centre. There may not be any facility for the safekeeping of these devices outside the examination hall; it will be prudent not to bring valuables to the examination center. Candidates will not be permitted to carry any food items in the exam centre. We suggest that you bring a bag to keep routine belongings outside the exam hall. Neither NPTEL nor the exam provider takes responsibility for the bag and the belongings. You may keep it outside at your own risk.</li>
            </ul>
        </div>

        <!-- Mandatory & Important Instructions -->
        <div class="section-title">Mandatory :</div>
        <div class="content">
            <ul>
                <li>Hall tickets have to be returned to the invigilator before leaving the exam hall. No paper can be taken out of the exam hall.</li>
                <li>Press the SUBMIT button on the computer after you have completed the exam.</li>
            </ul>
        </div>

        <div class="section-title">Important :</div>
        <div class="content">
            <ul>
                <li>A basic code of conduct during the exam should be followed, failing which, NPTEL reserves the right to take appropriate action.</li>
                <li>In case the exam is delayed due to any unforeseen circumstances, NPTEL will decide on the appropriate course of action as it deems fit.</li>
            </ul>
        </div>

        <!-- Contact Information -->
        <div class="section-title" style="text-transform: uppercase; font-weight: bold;">At the Exam Centre :</div>
        <div class="content">
            <p><strong>At the exam centre, if you encounter any issues with respect to the computer or exam officials, kindly contact the school exam representative, who will be available at the centre.</strong></p>
        </div>

        <!-- Declaration -->
        <div class="content">
            <p>I hereby acknowledge that I have read, understood and agree to follow the above mentioned instructions.</p>
        </div>

        <!-- Signature Box -->
        <div class="signature-box">
            <p>Signature of the Candidate</p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p><strong>Exam Controller</strong> - School Exam Authority</p>
        </div>
    </div>
</body>
</html>
