<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>RBT Note</title>
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #000;
        }
        td {
            padding: 5px;
            padding-top: 0px;
            text-align: left;
        }
        .session-info td {
            width: 20%;
        }
        #signature-table {
            border: none;
            border-top: none;
        }
        #signature-table td {
            border: none;
        }
        .patient-info td.half-width {
            width: 50%;
        }
        .patient-info td.quarter-width {
            width: 25%;
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
                        <strong>ABASWF</strong><br>
                        {{-- {{ $note->location->title }}<br> --}}
                        {{ $note->location->address }}<br>
                        {{ $note->location->city }}, {{ $note->location->state }} {{ $note->location->zip }}<br>
                        Phone: {{ $note->location->phone1 }}<br>
                        Email: {{ $note->location->email }}
                    </p>
                </td>
            </tr>
        </table>
    </div>

    <div class="title">
        APPOINTMENT NOTE
    </div>

    <table class="patient-info">
        <tr>
            <td colspan="2" class="half-width">
                <strong>Client:</strong><br>
                {{ $note->patient->first_name }} {{ $note->patient->last_name }}
            </td>
            <td colspan="1" class="quarter-width">
                <strong>Date of Birth:</strong><br>
                {{ $note->patient->birth_date->format('m/d/Y') }} ({{ $note->patient->age }} years old)
            </td>
            <td colspan="1" class="quarter-width">
                <strong>Insurance #:</strong><br>
                {{ $note->patient->insurance_identifier }}
            </td>
        </tr>
        <tr>
            <td colspan="2" class="half-width">
                <strong>Provider:</strong><br>
                {{ $note->provider->name }} {{ $note->provider->surname }}
            </td>
            <td colspan="2" class="half-width">
                <strong>Authorized ABA Supervisor:</strong><br>
                {{ $note->supervisor->name }} {{ $note->supervisor->surname }}
            </td>
        </tr>
    </table>

    <table class="session-info">
        <tr>
            <td>
                <strong>Date of Service:</strong><br>
                {{ $note->session_date->format('m/d/Y') }}
            </td>
            <td>
                <strong>Place of Service:</strong><br>
                {{ $note->posString }} ({{ $note->meet_with_client_at }})
            </td>
            <td>
                <strong>Time In/Out:</strong><br>
                {{ Carbon\Carbon::parse($note->time_in)->format('h:i A') }} - {{ Carbon\Carbon::parse($note->time_out)->format('h:i A') }}
                @if($note->time_in2)
                <br>
                {{ Carbon\Carbon::parse($note->time_in2)->format('h:i A') }} - {{ Carbon\Carbon::parse($note->time_out2)->format('h:i A') }}
                @endif
            </td>
            <td>
                <strong>Total Hours:</strong><br>
                @if ($note->total_minutes % 60 == 0)
                    {{ $note->total_minutes / 60 }} hours
                @else
                    {{ intdiv($note->total_minutes, 60) }} hours {{ $note->total_minutes % 60 }} minutes
                @endif
            </td>
            <td>
                <strong>Billing Codes:</strong><br>
                {{ $note->cpt_code }}
            </td>
        </tr>
    </table>

    <table>
        <tr>
            <td>
                <strong>Participants:</strong><br>
                {{ $note->participants }}
            </td>
            <td>
                <strong>Environmental Changes:</strong><br>
                {{ $note->environmental_changes }}
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <strong>Session Summary:</strong><br>
                {{ $note->summary_note }}
            </td>
        </tr>
    </table>

    <br><br><br><br>

    <table id="signature-table">
        <tr>
            <td>
                <br>
            </td>
            <td style="text-align: center;">
                {{ Carbon\Carbon::parse($note->session_date)->format('m/d/Y') }}
            </td>
        </tr>
        <tr>
            <td style="text-align: center;">
                ___________________________<br>
                <strong>PROVIDER SIGNATURE</strong>
            </td>
            <td style="text-align: center;">
                <br>
                ___________________________<br>
                <strong>SIGNATURE DATE</strong>
            </td>
        </tr>
    </table>
</body>
</html>
