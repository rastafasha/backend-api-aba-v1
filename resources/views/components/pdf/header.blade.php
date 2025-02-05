@props(['location'])

<div class="header">
    <table class="header-logo-table">
        <tr>
            <td class="header-logo-cell">
                <img src="{{ public_path('assets/img/aba-logo-new.webp') }}" class="logo" alt="Logo">
            </td>
            <td class="header-info-cell">
                <p>
                    <strong>ABASWF</strong><br>
                    {{ $location->address }}<br>
                    {{ $location->city }}, {{ $location->state }} {{ $location->zip }}<br>
                    Phone: {{ $location->phone1 ?? $location->phone }}<br>
                    Email: {{ $location->email }}
                </p>
            </td>
        </tr>
    </table>
</div>
