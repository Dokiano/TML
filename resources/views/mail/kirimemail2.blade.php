<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $data['subject'] }}</title>
</head>

<body>
    <h3>Berikut ini adalah progres dari PPK Anda dengan Nomor Surat: {{ $data['header'] }}</h3>
    <br>
    <p>Status PPK: <em>{{ $data['status'] }}</em></p>
    <br>
    <p>Update Progres PPK Anda dengan memasuki Menu PPK di Web DCMS dibawah ini</p>
    <p>Jaringan Cikarang <a href="http://174.16.3.82:8000/login">http://174.16.3.82:8000/login</a></p>
    <p>Luar Cikarang <a href="http://244.178.44.111:8000/login">http://244.178.44.111:8000/login</a></p>
</body>

</html>
