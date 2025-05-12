<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redirecting...</title>
    <script type="text/javascript">
        window.open("{{ $url }}", "_blank"); // Membuka URL di tab baru
        window.location.href = "{{ $url }}"; // Juga bisa mengarahkan pengguna ke halaman yang sama (optional)
    </script>
</head>
<body>
    <p>Redirecting to <a href="{{ $url }}" target="_blank">{{ $url }}</a>...</p>
</body>
</html>
