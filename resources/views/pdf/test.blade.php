<!DOCTYPE html>
<html>
<head>
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .header {
            text-align: center;
            color: #333;
            padding-bottom: 20px;
        }
        .date {
            text-align: right;
            color: #666;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="date">{{ $date }}</div>
    <div class="header">
        <h1>{{ $title }}</h1>
    </div>
    <div class="content">
        <p>This is a sample PDF generated using Laravel DomPDF.</p>
    </div>
</body>
</html>
