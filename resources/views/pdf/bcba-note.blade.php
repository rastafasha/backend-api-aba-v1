<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>BCBA Supervision Note</title>
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
            text-align: left;
        }
        .signature-table {
            border: none;
            margin-top: 30px;
        }
        .signature-table td {
            border: none;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <table style="width: 100%; border: none;">
            <tr>
                <td style="width: 80px; vertical-align: middle; text-align: right; border: none;">
                    <img src="{{ public_path('assets/img/aba-logo-new.webp') }}" class="logo" alt="Logo">
                </td>
                <td style="vertical-align: middle; text-align: left; padding-left: 15px; border: none;">
                    <p>
                        <strong>ABASWF</strong><br>
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
        BCBA SUPERVISION NOTE
    </div>

    <table>
        <tr>
            <td style="width: 50%">
                <strong>Client:</strong><br>
                {{ $note->patient->first_name }} {{ $note->patient->last_name }}
            </td>
            <td style="width: 25%">
                <strong>Date of Birth:</strong><br>
                {{ $note->patient->birth_date->format('m/d/Y') }}
            </td>
            <td style="width: 25%">
                <strong>Insurance #:</strong><br>
                {{ $note->patient->insurance_identifier }}
            </td>
        </tr>
    </table>

    <table>
        <tr>
            <td style="width: 33%">
                <strong>Session Date:</strong><br>
                {{ $note->session_date->format('m/d/Y') }}
            </td>
            <td style="width: 33%">
                <strong>Time:</strong><br>
                {{ Carbon\Carbon::parse($note->time_in)->format('h:i A') }} - {{ Carbon\Carbon::parse($note->time_out)->format('h:i A') }}
                @if($note->time_in2)
                <br>
                {{ Carbon\Carbon::parse($note->time_in2)->format('h:i A') }} - {{ Carbon\Carbon::parse($note->time_out2)->format('h:i A') }}
                @endif
            </td>
            <td style="width: 33%">
                <strong>CPT Code:</strong><br>
                {{ $note->cpt_code }}
            </td>
        </tr>
    </table>


    <table class="signature-table">
        <tr>
            <td style="width: 50%">
                ___________________________<br>
                <strong>BCBA Signature</strong><br>
                {{ $note->provider_signature }}
            </td>
            <td style="width: 50%">
                ___________________________<br>
                <strong>Date</strong><br>
                {{ $note->session_date->format('m/d/Y') }}
            </td>
        </tr>
    </table>
</body>
</html>
