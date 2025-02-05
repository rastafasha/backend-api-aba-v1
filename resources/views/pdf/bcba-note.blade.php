<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>BCBA Supervision Note</title>
    <link rel="stylesheet" href="{{ base_path('resources/views/pdf/styles/base.css') }}">
</head>

<body>
    <x-pdf.footer :location="$note->location" />
    <x-pdf.header :location="$note->location" />

    <h1>
        BCBA SUPERVISION NOTE
    </h1>

    <table class="patient-info">
        <tr>
            <td colspan="2" class="w-50">
                <strong>Client:</strong><br>
                {{ $note->patient->first_name }} {{ $note->patient->last_name }}
            </td>
            <td colspan="1" class="w-25">
                <strong>Date of Birth:</strong><br>
                {{ $note->patient->birth_date->format('m/d/Y') }} ({{ $note->patient->age }} years old)
            </td>
            <td colspan="1" class="w-25">
                <strong>Insurance #:</strong><br>
                {{ $note->patient->insurance_identifier }}
            </td>
        </tr>
        <tr>
            <td colspan="2" class="w-50">
                <strong>Provider:</strong><br>
                {{ $note->provider->name }} {{ $note->provider->surname }}
            </td>
            <td colspan="2" class="w-50">
                <strong>Authorized ABA Supervisor:</strong><br>
                {{ $note->supervisor->name }} {{ $note->supervisor->surname }}
            </td>
        </tr>
    </table>

    <table>
        <tr>
            <td colspan="2">
                <strong>Participants:</strong><br>
                {{ $note->participants }}
            </td>
            {{-- <td>
                <strong>Environmental Changes:</strong><br>
                {{ $note->environmental_changes }}
            </td> --}}
        </tr>
        <tr>
            <td colspan="2">
                <strong>Session Summary:</strong><br>
                {{ $note->summary_note }}
            </td>
        </tr>
    </table>

    <table>
        <tr>
            <td class="w-20">
                <strong>Date of Service:</strong><br>
                {{ $note->session_date->format('m/d/Y') }}
            </td>
            <td class="w-20">
                <strong>Place of Service:</strong><br>
                {{ $note->posString }} ({{ $note->meet_with_client_at }})
            </td>
            <td class="w-20">
                <strong>Time In/Out:</strong><br>
                {{ Carbon\Carbon::parse($note->time_in)->format('h:i A') }} -
                {{ Carbon\Carbon::parse($note->time_out)->format('h:i A') }}
                @if ($note->time_in2)
                    <br>
                    {{ Carbon\Carbon::parse($note->time_in2)->format('h:i A') }} -
                    {{ Carbon\Carbon::parse($note->time_out2)->format('h:i A') }}
                @endif
            </td>
            <td class="w-20">
                <strong>Total Hours:</strong><br>
                @if ($note->total_minutes % 60 == 0)
                    {{ $note->total_minutes / 60 }} hours
                @else
                    {{ intdiv($note->total_minutes, 60) }} hours {{ $note->total_minutes % 60 }} minutes
                @endif
            </td>
            <td class="w-20">
                <strong>Billing Codes:</strong><br>
                {{ $note->cpt_code }}
            </td>
        </tr>
    </table>

    <br><br><br><br>

    <table class="table-borderless">
        <tr>
            <td class="text-center">
                <div class="signature-line"></div>
                <strong>PROVIDER SIGNATURE</strong>
            </td>
            <td class="text-center">
                <div class="signature-line"></div>
                <strong>SUPERVISOR SIGNATURE</strong>
            </td>
        </tr>
        <tr>
            <td class="text-center">
                <br>
                {{ Carbon\Carbon::parse($note->session_date)->format('m/d/Y') }}
            </td>
            <td class="text-center">
                <br>
                {{ Carbon\Carbon::parse($note->session_date)->format('m/d/Y') }}
            </td>
        </tr>
        <tr>
            <td class="text-center">
                <div class="signature-line"></div>
                <strong>SIGNATURE DATE</strong>
            </td>
            <td class="text-center">
                <div class="signature-line"></div>
                <strong>SIGNATURE DATE</strong>
            </td>
        </tr>
    </table>
</body>

</html>
