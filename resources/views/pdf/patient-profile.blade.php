<?php

use Carbon\Carbon;

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Patient Profile</title>
    <link rel="stylesheet" href="{{ base_path('resources/views/pdf/styles/base.css') }}">
</head>

<body>
    <footer class="footer">
        {{ $patient->location->title }}, {{ $patient->location->city }}, {{ \Carbon\Carbon::now()->format('F j, Y') }}
    </footer>
    <footer class="page-number">
        Page <span class="pagenum"></span>
    </footer>
    <main>
        <div class="header">
            <table class="header-logo-table">
                <tr>
                    <td class="header-logo-cell">
                        <img src="{{ public_path('assets/img/aba-logo-new.webp') }}" class="logo" alt="Logo">
                    </td>
                    <td class="header-info-cell">
                        <p>
                            <strong>{{ $patient->location->title }}</strong><br>
                            {{ $patient->location->address }}<br>
                            {{ $patient->location->city }}, {{ $patient->location->state }}
                            {{ $patient->location->zip }}<br>
                            Phone: {{ $patient->location->phone }}<br>
                            Email: {{ $patient->location->email }}
                        </p>
                    </td>
                </tr>
            </table>
        </div>

        <h1>
            PATIENT PROFILE
        </h1>

        <!-- General Information Section -->
        <table>
            <tr>
                <td colspan="3" class="section-header">PATIENT INFORMATION</td>
            </tr>
            <tr>
                <td style="width: 33%">
                    <strong>Patient's Full Name:</strong><br>
                    {{ $patient->first_name }} {{ $patient->last_name }}
                </td>
                <td style="width: 33%">
                    <strong>Date of Birth:</strong><br>
                    {{ is_string($patient->birth_date) ? Carbon::parse($patient->birth_date)->format('m/d/Y') : $patient->birth_date->format('m/d/Y') }}
                    ({{ $patient->age }} years)
                </td>
                <td style="width: 33%">
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
                    {{ $patient->language ?? 'N/A' }}
                </td>
                <td>
                    <strong>Education:</strong><br>
                    {{ $patient->education ?? 'N/A' }}
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Schedule:</strong><br>
                    {{ $patient->schedule ?? 'N/A' }}
                </td>
                <td>
                    <strong>Summer Schedule:</strong><br>
                    {{ $patient->summer_schedule ?? 'N/A' }}
                </td>
                <td>
                    <strong>Profession:</strong><br>
                    {{ $patient->profession ?? 'N/A' }}
                </td>
            </tr>
        </table>

        <!-- Contact Information -->
        <table>
            <tr>
                <td colspan="3" class="section-header">CONTACT INFORMATION</td>
            </tr>
            <tr>
                <td style="width: 33%">
                    <strong>Address:</strong><br>
                    {{ $patient->address }}<br>
                </td>
                <td style="width: 33%">
                    <strong>City, State, Zip:</strong><br>
                    {{ $patient->city }}, {{ $patient->state }} {{ $patient->zip }}
                </td>
                <td style="width: 33%">
                    <strong>Email:</strong><br>
                    {{ $patient->email }}
                </td>
            </tr>
            <tr>
                <td style="width: 33%">
                    <strong>Mobile Phone:</strong><br>
                    {{ $patient->phone ?? 'N/A' }}
                </td>
                <td style="width: 33%">
                    <strong>Home Phone:</strong><br>
                    {{ $patient->home_phone ?? 'N/A' }}
                </td>
                <td style="width: 33%">
                    <strong>Work Phone:</strong><br>
                    {{ $patient->work_phone ?? 'N/A' }}
                </td>
            </tr>
        </table>

        <!-- Guardian Information -->
        <table>
            <tr>
                <td colspan="3" class="section-header">PARENT/GUARDIAN INFORMATION</td>
            </tr>
            <tr>
                <td style="width: 33%">
                    <strong>Parent/Guardian Name:</strong><br>
                    {{ $patient->parent_guardian_name }}
                </td>
                <td style="width: 33%">
                    <strong>Relationship:</strong><br>
                    {{ $patient->relationship }}
                </td>
                <td style="width: 33%">
                    <strong>Parent/Guardian Gender:</strong><br>
                    {{ $patient->parent_gender == 1 ? 'Male' : 'Female' }}
                </td>
            </tr>
            <tr>
                <td style="width: 33%">
                    <strong>Parent/Guardian Birth Date:</strong><br>
                    {{ is_string($patient->parent_birth_date) ? Carbon::parse($patient->parent_birth_date)->format('m/d/Y') : $patient->parent_birth_date->format('m/d/Y') }}
                </td>
                <td style="width: 33%">
                    <strong>Parent/Guardian Address:</strong><br>
                    {{ $patient->parent_address ?? 'N/A' }}<br>
                </td>
                <td style="width: 33%">
                    <strong>Parent/Guardian City, State, Zip:</strong><br>
                    {{ $patient->parent_city }}, {{ $patient->parent_state }} {{ $patient->parent_zip }}
                </td>
            </tr>
        </table>

        <!-- School Information -->
        <table>
            <tr>
                <td colspan="2" class="section-header">SCHOOL INFORMATION</td>
            </tr>
            <tr>
                <td style="width: 50%">
                    <strong>School Name:</strong><br>
                    {{ $patient->school_name ?? 'N/A' }}
                </td>
                <td style="width: 50%">
                    <strong>School Number:</strong><br>
                    {{ $patient->school_number ?? 'N/A' }}
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

        <!-- PAGE BREAK -->
        <div class="page-break"></div>

        <!-- Insurance Information -->
        <table>
            <tr>
                <td colspan="4" class="section-header">INSURANCE INFORMATION</td>
            </tr>
            <tr>
                <td style="width: 25%">
                    <strong>Primary Insurance:</strong><br>
                    {{ $patient->insurer ? $patient->insurer->name : 'N/A' }}
                </td>
                <td style="width: 25%">
                    <strong>Insurance ID:</strong><br>
                    {{ $patient->insurance_identifier ?? 'N/A' }}
                </td>
                <td style="width: 25%">
                    <strong>Secondary Insurance:</strong><br>
                    {{ $patient->insurance_secondary ? $patient->insurance_secondary->name : 'N/A' }}
                </td>
                <td style="width: 25%">
                    <strong>Secondary ID:</strong><br>
                    {{ $patient->insurance_secondary_identifier ?? 'N/A' }}
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Equhl Id:</strong><br>
                    {{ $patient->equhl_id ?? 'N/A' }}
                </td>
                <td>
                    <strong>Eligibility Date:</strong><br>
                    {{ is_string($patient->elegibility_date) ? Carbon::parse($patient->elegibility_date)->format('m/d/Y') : $patient->elegibility_date->format('m/d/Y') }}
                </td>
                <td>
                    <strong>POS Covered:</strong><br>
                    {{ $patient->pos_covered ? implode(', ', $patient->pos_covered) : 'N/A' }}
                </td>
                <td>
                    <strong>Deductible Individual I/F:</strong><br>
                    {{ $patient->deductible_individual_if ?? 'N/A' }}
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Balance:</strong><br>
                    {{ $patient->balance ?? 'N/A' }}
                </td>
                <td>
                    <strong>Coinsurance:</strong><br>
                    {{ $patient->coinsurance ?? 'N/A' }}
                </td>
                <td>
                    <strong>Copayments:</strong><br>
                    {{ $patient->copayments ?? 'N/A' }}
                </td>
                <td>
                    <strong>OOP:</strong><br>
                    {{ $patient->oop ?? 'N/A' }}
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Patient Control #:</strong><br>
                    {{ $patient->patient_control ?? 'N/A' }}
                </td>
                <td>
                    <strong>Telehealth:</strong><br>
                    {{ $patient->telehealth ? 'Yes' : 'No' }}
                </td>
                <td>
                    <strong>Pay:</strong><br>
                    {{ $patient->pay ? 'Yes' : 'No' }}
                </td>
                <td>
                    <strong>Is Self Subscriber:</strong><br>
                    {{ $patient->is_self_subscriber ? 'Yes' : 'No' }}
                </td>
            </tr>
        </table>

        <!-- Clinical Information Section -->
        <table>
            <tr>
                <td colspan="3" class="section-header">CLINICAL INFORMATION</td>
            </tr>
            <tr>
                <td style="width: 66%">
                    <strong>Diagnosis Code:</strong><br>
                    {{ $patient->diagnosis_code }}
                </td>
                {{-- <td style="width: 33%">
                    <strong>Status:</strong><br>
                    {{ ucfirst($patient->status) }}
                </td> --}}
                <td style="width: 33%">
                    <strong>NPI:</strong><br>
                    {{ $patient->npi }}
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <strong>Referring Provider:</strong><br>
                    {{ $patient->referring_provider_first_name }} {{ $patient->referring_provider_last_name }}
                </td>
                <td>
                    <strong>Referring NPI:</strong><br>
                    {{ $patient->referring_provider_npi ?? 'N/A' }}
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <strong>Is condition related to...</strong><br>
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Employment:</strong><br>
                    {{ $patient->is_condition_related_to ? 'Yes' : 'No' }}
                </td>
                <td>
                    <strong>Auto Accident:</strong><br>
                    {{ $patient->auto_accident ? 'Yes' : 'No' }}
                </td>
                <td>
                    <strong>Other Accident:</strong><br>
                    {{ $patient->other_accident ? 'Yes' : 'No' }}
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <strong>Special Notes:</strong><br>
                    {{ $patient->special_note }}
                </td>
            </tr>
        </table>

        <!-- Specialists -->
        <table>
            <tr>
                <td colspan="2" class="section-header">SPECIALISTS</td>
            </tr>
            <tr>
                <td style="width: 50%">
                    <strong>RBT Home:</strong><br>
                    {{ $patient->rbt_home ? $patient->rbt_home->name . ' ' . $patient->rbt_home->surname : 'N/A' }}
                </td>
                <td style="width: 50%">
                    <strong>RBT School:</strong><br>
                    {{ $patient->rbt2_school ? $patient->rbt2_school->name . ' ' . $patient->rbt2_school->surname : 'N/A' }}
                </td>
            </tr>
            <tr>
                <td style="width: 50%">
                    <strong>BCBA Home:</strong><br>
                    {{ $patient->bcba_home ? $patient->bcba_home->name . ' ' . $patient->bcba_home->surname : 'N/A' }}
                </td>
                <td style="width: 50%">
                    <strong>BCBA School:</strong><br>
                    {{ $patient->bcba2_school ? $patient->bcba2_school->name . ' ' . $patient->bcba2_school->surname : 'N/A' }}
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <strong>Clinical Director:</strong><br>
                    {{ $patient->clin_director ? $patient->clin_director->name . ' ' . $patient->clin_director->surname : 'N/A' }}
                </td>
            </tr>
        </table>

        <!-- PA Services -->
        <table>
            <tr>
                <td colspan="6">
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
                {{-- <td><strong>Spent Units</strong></td> --}}
            </tr>
            @foreach ($patient->paServices as $pa)
                <tr>
                    <td>{{ $pa->pa_service }}</td>
                    <td>{{ is_string($pa->start_date) ? Carbon::parse($pa->start_date)->format('m/d/Y') : $pa->start_date->format('m/d/Y') }}
                    </td>
                    <td>{{ is_string($pa->end_date) ? Carbon::parse($pa->end_date)->format('m/d/Y') : $pa->end_date->format('m/d/Y') }}
                    </td>
                    <td>{{ $pa->cpt }}</td>
                    <td>{{ $pa->n_units }}</td>
                    <td>{{ $pa->n_units }}</td>
                    {{-- <td>{{ $pa->spent_units }}</td> --}}
                </tr>
            @endforeach
        </table>
    </main>
</body>

</html>
