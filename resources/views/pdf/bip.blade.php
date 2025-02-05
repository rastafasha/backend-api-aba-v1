<?php

use Carbon\Carbon;

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Behavior Analysis Assessment (BIP)</title>
    <link rel="stylesheet" href="{{ base_path('resources/views/pdf/styles/base.css') }}">
    <style>
        .type_of_assessment_symbol {
            font-size: 18px;
            display: inline-block;
            width: 12px;
            height: 12px;
            border: 1px solid black;
            margin-right: 5px;
            vertical-align: middle;
            line-height: 8px;
            text-align: center;
        }
    </style>
</head>

<body>
    <x-pdf.footer :location="$patient->location" />
    <footer class="page-number">
        Page <span class="pagenum"></span>
    </footer>
    <main>
        <x-pdf.header :location="$patient->location" />

        <h1>
            BEHAVIOR ANALYSIS ASSESSMENT
        </h1>

        <table class="patient-info">
            <tr>
                <td colspan="1" class="w-33">
                    <strong>Client:</strong><br>
                    {{ $patient->first_name }} {{ $patient->last_name }}
                </td>
                <td colspan="1" class="w-33">
                    <strong>Date of Birth:</strong><br>
                    {{ $patient->birth_date->format('m/d/Y') }} ({{ $patient->age }} years old)
                </td>
                <td colspan="1" class="w-33">
                    <strong>Member ID#:</strong><br>
                    {{ $patient->patient_identifier }}
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <strong>Report Writer:</strong><br>
                    {{ 'undefined' }} {{ 'undefined' }}
                </td>
                <td colspan="1" class="w-33">
                    <strong>Date of Report:</strong><br>
                    {{ Carbon::now()->format('m/d/Y') }}
                </td>
            </tr>
        </table>

        <h2>
            TYPE OF ASSESSMENT:
        </h2>

        <div style="text-align: center; margin: 1em 0;">
            <span style="margin: 0 2em;">
                <span class="symbol type_of_assessment_symbol">
                    @if ($bip->type_of_assessment === 1)
                        &#x2713;
                    @endif
                </span>
                Initial Assessment
            </span>
            <span style="margin: 0 2em;">
                <span class="symbol type_of_assessment_symbol">
                    @if ($bip->type_of_assessment === 2)
                        &#x2713;
                    @endif
                </span>
                Reassessment
            </span>
        </div>

        <h2>
            DOCUMENT REVIEWED:
        </h2>

        <ul>
            @foreach (array_filter($bip->assestment_conducted_options, function ($document) {
        return $document['status'] === 'yes';
    }) as $document)
                <li>{{ $document['title'] }}</li>
            @endforeach
        </ul>

        <h2>
            BACKGROUND INFORMATION:
        </h2>

        @foreach (explode("\n", $bip->background_information) as $line)
            <p class="paragraph">{{ $line }}</p>
        @endforeach

        <h3>
            Previous Treatment and Result:
        </h3>

        @foreach (explode("\n", $bip->previous_treatment_and_result) as $line)
            <p class="paragraph">{{ $line }}</p>
        @endforeach

    </main>
</body>

</html>
