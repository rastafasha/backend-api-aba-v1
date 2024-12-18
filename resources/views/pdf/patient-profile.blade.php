<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Patient Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 40px;
            font-size: 11px;
        }
        .header {
            margin-bottom: 15px;
            text-align: center;
        }
        .header img, .logo {
            max-width: 80px;
            height: auto;
        }
        .header p {
            margin: 0;
            text-align: left;
            font-size: 10px;
            line-height: 1.2;
        }
        .logo {
            margin-bottom: 0;
        }
        .title {
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            margin: 20px 0;
        }
        .page-break {
            page-break-before: always;
        }
        .section-header {
            background-color: #f8f9fa;
            padding: 5px;
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            page-break-inside: avoid;
        }
        table, th, td {
            border: 1px solid #000;
        }
        td {
            padding: 5px;
            padding-top: 0px;
            text-align: left;
            vertical-align: top;
        }
    </style>
</head>
<body>
    <div class="header">
        <table style="width: 100%; border: none; border-collapse: collapse;">
            <tr>
                <td style="width: 80px; vertical-align: middle; text-align: right; border: none;">
                    <img src="{{ public_path('assets/img/aba-logo-new.webp') }}" class="logo" alt="Logo">
                </td>
                <td style="vertical-align: middle; text-align: left; padding-left: 15px; border: none;">
                    <p>
                        <strong>{{ $patient->locals->title }}</strong><br>
                        {{ $patient->locals->address }}<br>
                        {{ $patient->locals->city }}, {{ $patient->locals->state }} {{ $patient->locals->zip }}<br>
                        Phone: {{ $patient->locals->phone }}<br>
                        Email: {{ $patient->locals->email }}
                    </p>
                </td>
            </tr>
        </table>
    </div>

    <div class="title">
        PATIENT PROFILE
    </div>

    <!-- General Information Section -->
    <table>
        <tr>
            <td colspan="3" class="section-header">PATIENT INFORMATION</td>
        </tr>
        <tr>
            <td style="width: 50%">
                <strong>Patient's Full Name:</strong><br>
                {{ $patient->first_name }} {{ $patient->last_name }}
            </td>
            <td style="width: 25%">
                <strong>Date of Birth:</strong><br>
                {{ $patient->birth_date->format('m/d/Y') }} ({{ $patient->age }} years)
            </td>
            <td style="width: 25%">
                <strong>Patient ID:</strong><br>
                {{ $patient->patient_identifier }}
            </td>
        </tr>
        <tr>
            <td>
                <strong>Gender:</strong><br>
                {{ $patient->gender == 1 ? 'Male' : 'Female' }}
            </td>
            <td>
                <strong>Language:</strong><br>
                {{ $patient->language }}
            </td>
            <td>
                <strong>Education:</strong><br>
                {{ $patient->education }}
            </td>
        </tr>
    </table>

    <!-- Contact Information -->
    <table>
        <tr>
            <td colspan="3" class="section-header">CONTACT INFORMATION</td>
        </tr>
        <tr>
            <td>
                <strong>Address:</strong><br>
                {{ $patient->address }}<br>
                {{ $patient->city }}, {{ $patient->state }} {{ $patient->zip }}
            </td>
            <td>
                <strong>Phone:</strong><br>
                {{ $patient->phone }}
            </td>
            <td>
                <strong>Email:</strong><br>
                {{ $patient->email }}
            </td>
        </tr>
    </table>

    <!-- Guardian Information -->
    <table>
        <tr>
            <td colspan="4" class="section-header">GUARDIAN INFORMATION</td>
        </tr>
        <tr>
            <td style="width: 25%">
                <strong>Guardian Name:</strong><br>
                {{ $patient->parent_guardian_name }}
            </td>
            <td style="width: 25%">
                <strong>Relationship:</strong><br>
                {{ $patient->relationship }}
            </td>
            <td style="width: 25%">
                <strong>Guardian Gender:</strong><br>
                {{ $patient->parent_gender == 1 ? 'Male' : 'Female' }}
            </td>
            <td style="width: 25%">
                <strong>Guardian Birth Date:</strong><br>
                {{ $patient->parent_birth_date ? $patient->parent_birth_date->format('m/d/Y') : 'N/A' }}
            </td>
        </tr>
        <tr>
            <td>
                <strong>Home Phone:</strong><br>
                {{ $patient->home_phone }}
            </td>
            <td>
                <strong>Work Phone:</strong><br>
                {{ $patient->work_phone }}
            </td>
            <td colspan="2">
                <strong>Is Self Subscriber:</strong><br>
                {{ $patient->is_self_subscriber ? 'Yes' : 'No' }}
            </td>
        </tr>
    </table>

    <!-- School Information -->
    <table>
        <tr>
            <td colspan="3" class="section-header">SCHOOL INFORMATION</td>
        </tr>
        <tr>
            <td style="width: 40%">
                <strong>School Name:</strong><br>
                {{ $patient->school_name }}
            </td>
            <td style="width: 30%">
                <strong>School Number:</strong><br>
                {{ $patient->school_number }}
            </td>
            <td style="width: 30%">
                <strong>Profession:</strong><br>
                {{ $patient->profession }}
            </td>
        </tr>
        <tr>
            <td>
                <strong>Schedule:</strong><br>
                {{ $patient->schedule }}
            </td>
            <td colspan="2">
                <strong>Summer Schedule:</strong><br>
                {{ $patient->summer_schedule }}
            </td>
        </tr>
    </table>

    <!-- Intake Status -->
    <table>
        <tr>
            <td colspan="4" class="section-header">INTAKE STATUS</td>
        </tr>
        <tr>
            <td style="width: 25%">
                <strong>Welcome:</strong><br>
                {{ ucfirst($patient->welcome) }}
            </td>
            <td style="width: 25%">
                <strong>Consent:</strong><br>
                {{ ucfirst($patient->consent) }}
            </td>
            <td style="width: 25%">
                <strong>Insurance Card:</strong><br>
                {{ ucfirst($patient->insurance_card) }}
            </td>
            <td style="width: 25%">
                <strong>Eligibility:</strong><br>
                {{ ucfirst($patient->eligibility) }}
            </td>
        </tr>
        <tr>
            <td>
                <strong>MNL:</strong><br>
                {{ ucfirst($patient->mnl) }}
            </td>
            <td>
                <strong>Referral:</strong><br>
                {{ ucfirst($patient->referral) }}
            </td>
            <td>
                <strong>ADOS:</strong><br>
                {{ ucfirst($patient->ados) }}
            </td>
            <td>
                <strong>IEP:</strong><br>
                {{ ucfirst($patient->iep) }}
            </td>
        </tr>
        <tr>
            <td>
                <strong>ASD Diagnosis:</strong><br>
                {{ ucfirst($patient->asd_diagnosis) }}
            </td>
            <td>
                <strong>CDE:</strong><br>
                {{ ucfirst($patient->cde) }}
            </td>
            <td>
                <strong>Submitted:</strong><br>
                {{ ucfirst($patient->submitted) }}
            </td>
            <td>
                <strong>Interview:</strong><br>
                {{ ucfirst($patient->interview) }}
            </td>
        </tr>
    </table>

    <!-- Clinical Information Section -->
    <table>
        <tr>
            <td colspan="2" class="section-header">CLINICAL INFORMATION</td>
        </tr>
        <tr>
            <td style="width: 50%">
                <strong>Diagnosis Code:</strong><br>
                {{ $patient->diagnosis_code }}
            </td>
            <td style="width: 50%">
                <strong>Status:</strong><br>
                {{ ucfirst($patient->status) }}
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <strong>Special Notes:</strong><br>
                {{ $patient->special_note }}
            </td>
        </tr>
    </table>

    <!-- Add page break before Insurance Information -->
    <div class="page-break"></div>

    <!-- Insurance Information -->
    <table>
        <tr>
            <td colspan="4" class="section-header">INSURANCE INFORMATION</td>
        </tr>
        <tr>
            <td style="width: 25%">
                <strong>Primary Insurance:</strong><br>
                {{ $patient->insurer_name }}
            </td>
            <td style="width: 25%">
                <strong>Insurance ID:</strong><br>
                {{ $patient->insurance_identifier }}
            </td>
            <td style="width: 25%">
                <strong>Secondary Insurance:</strong><br>
                {{ $patient->insurer_name_secondary }}
            </td>
            <td style="width: 25%">
                <strong>Secondary ID:</strong><br>
                {{ $patient->insurance_secondary_identifier }}
            </td>
        </tr>
        <tr>
            <td colspan="4">
                <strong>Eligibility Date:</strong><br>
                {{ $patient->elegibility_date ? $patient->elegibility_date->format('m/d/Y') : 'N/A' }}
            </td>
        </tr>
    </table>

    <!-- PA Services -->
    <table>
        <tr>
            <td colspan="7">
                <strong>PA SERVICES</strong>
            </td>
        </tr>
        <tr>
            <td><strong>PA #</strong></td>
            <td><strong>Start Date</strong></td>
            <td><strong>End Date</strong></td>
            <td><strong>CPT</strong></td>
            <td><strong>Units Assigned</strong></td>
            <td><strong>Units Available</strong></td>
            <td><strong>Spent Units</strong></td>
        </tr>
        @foreach($patient->paServices as $pa)
        <tr>
            <td>{{ $pa->pa_service }}</td>
            <td>{{ $pa->start_date->format('m/d/Y') }}</td>
            <td>{{ $pa->end_date->format('m/d/Y') }}</td>
            <td>{{ $pa->cpt }}</td>
            <td>{{ $pa->n_units }}</td>
            <td>{{ $pa->n_units }}</td>
            <td>{{ $pa->spent_units }}</td>
        </tr>
        @endforeach
    </table>
</body>
</html>
