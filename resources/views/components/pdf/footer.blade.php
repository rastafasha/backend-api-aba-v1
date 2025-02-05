@props(['location'])

<footer class="footer">
    {{ $location->title }}, {{ $location->city }}, {{ \Carbon\Carbon::now()->format('F j, Y') }}
</footer>
