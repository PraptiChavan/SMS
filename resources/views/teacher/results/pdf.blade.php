<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Grade Report</title>

    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            line-height: 1.4;
            margin: 0;
            padding: 0;
        }

        /* Ensure A4 size fits content properly */
        @page {
            size: A4 portrait;
            margin: 10mm; /* Smaller margins to avoid cutoff */
        }

        .container {
            width: 100%;
            max-width: 700px; /* Adjust width if needed */
            margin: 0 auto; /* Centers the container */
            border: 1px solid #000;
            padding: 10px;
            box-sizing: border-box;
        }

        /* Header styling */
        .header {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 5px;
        }

        /* Table styling */
        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: auto; /* Allows columns to adjust properly */
        }

        /* Table cells styling */
        td, th {
            padding: 5px 8px;
            border: 1px solid #000;
            text-align: center;
            word-wrap: break-word; /* Ensures content wraps in narrow cells */
        }

        /* Info table labels */
        .info-label {
            font-weight: bold;
            background-color: #f0f0f0;
            width: 20%;
        }

        /* Grading system styling */
        .details-table th {
            background-color: #f0f0f0;
            font-weight: bold;
        }

        /* Add margin between tables */
        .details-table {
            margin-top: 15px; /* Space between the grade table and grading system */
        }

        /* Space below Grading System heading */
        .section-title {
            margin-top: 20px;
            margin-bottom: 10px; /* Added space after the heading */
            text-align: center;
            font-weight: bold;
            text-decoration: underline;
        }

        /* Push the grading system and table to the bottom of the page */
        .grading-container {
            margin-top: auto;
            padding-top: 350px;
            min-height: 400px; /* Adjust this value based on content length */
            display: flex;
            flex-direction: column;
            justify-content: flex-end; /* Ensures content sticks to the bottom */
        }

        /* Small footer note styling */
        .small-note {
            font-size: 10px;
            font-style: italic;
            text-align: center;
            margin-top: 10px;
        }

        /* Signature positioning */
        .signature {
            margin-top: 40px;
            text-align: right;
            font-weight: bold;
        }

        /* Fixes for width overflow issues */
        td, th {
            max-width: 100px; /* Prevents cells from stretching too much */
            word-break: break-word; /* Wrap long words properly */
        }

    </style>
    
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div class="header">Student Grade Report</div>

        <!-- Student Information -->
        <table class="info-table">
            <tr>
                <td class="info-label">Name:</td>
                <td>{{ $student->name }}</td>
                <td class="info-label">Enrollment No:</td>
                <td>{{ $student->id }}</td>
            </tr>
            <tr>
                <td class="info-label">Class:</td>
                <td>{{ \App\Models\admin\ClassModel::find($student->classes)->title ?? 'N/A' }}</td>
                <td class="info-label">Section:</td>
                <td>{{ \App\Models\admin\Section::find($student->sections)->title ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="info-label">Seat No:</td>
                <td>{{ $student->id }}</td>
                <td class="info-label">School:</td>
                <td>{{ $student->school_name ?? 'N/A' }}</td>
            </tr>
        </table>

        <!-- Grade Table -->
        <table class="details-table">
            <thead>
                <tr>
                    <th>Subject</th>
                    <th>Exam Name</th>
                    <th>Obtained Marks</th>
                    <th>Total Marks</th>
                    <th>Percentage</th>
                    <th>Grade</th>
                </tr>
            </thead>

            <tbody>
                @php
                    // ✅ Convert comma-separated strings back into arrays
                    $subjectNamesArray = explode(',', $subjects);
                    $totalMarksArray = explode(',', $total_marks);
                    $obtainedMarksArray = explode(',', $obtained_marks);
                    $percentagesArray = explode(',', $percentage);
                    $gradesArray = explode(',', $grade);

                    // ✅ Ensure the number of rows matches
                    $maxRows = max(
                        count($subjectNamesArray),
                        count($totalMarksArray),
                        count($obtainedMarksArray),
                        count($percentagesArray),
                        count($gradesArray)
                    );
                @endphp

                <!-- ✅ Display rows -->
                @for ($i = 0; $i < $maxRows; $i++)
                    <tr>
                        <td>{{ $subjectNamesArray[$i] ?? 'N/A' }}</td>
                        <td>{{ $exam_name }}</td>
                        <td>{{ $obtainedMarksArray[$i] ?? '0' }}</td>
                        <td>{{ $totalMarksArray[$i] ?? '0' }}</td>
                        <td>{{ $percentagesArray[$i] ?? '0' }}%</td>
                        <td>{{ $gradesArray[$i] ?? 'N/A' }}</td>
                    </tr>
                @endfor
            </tbody>
        </table>

        <!-- Grading System -->
        <div class="grading-container">
            <div class="section-title">Grading System</div>
            <table class="details-table">
                <tr>
                    <th>% Marks</th>
                    <th>Description</th>
                    <th>Letter Grade</th>
                    <th>Grade Point</th>
                </tr>
                <tr>
                    <td>90-100</td>
                    <td>Outstanding</td>
                    <td>A+</td>
                    <td>10</td>
                </tr>
                <tr>
                    <td>80-89</td>
                    <td>Excellent</td>
                    <td>A</td>
                    <td>9</td>
                </tr>
                <tr>
                    <td>70-79</td>
                    <td>Very Good</td>
                    <td>B+</td>
                    <td>8</td>
                </tr>
                <tr>
                    <td>60-69</td>
                    <td>Good</td>
                    <td>B</td>
                    <td>7</td>
                </tr>
                <tr>
                    <td>50-59</td>
                    <td>Above Average</td>
                    <td>C</td>
                    <td>6</td>
                </tr>
                <tr>
                    <td>40-49</td>
                    <td>Pass</td>
                    <td>P</td>
                    <td>5</td>
                </tr>
                <tr>
                    <td>Below 40</td>
                    <td>Fail</td>
                    <td>F</td>
                    <td>0</td>
                </tr>
            </table>

            <!-- Footer Note -->
            <div class="small-note">This is a system-generated grade sheet.</div>

            <!-- Signature -->
            <div class="signature">Authorized Signature</div>
        </div>
    </div>
</body>
</html>
