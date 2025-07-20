<!DOCTYPE html>
<html>
<head>
    <title>Foglalás Megerősítése</title>
</head>
<body>
    <h1>Kedves {{ $booking->name }}!</h1>
    <p>Kérjük, erősítse meg foglalási szándékát az alábbi linkre kattintva. A link 60 percig érvényes.</p>
    <a href="{{ $verificationUrl }}">Foglalás megerősítése</a>
    <p>Ha nem Ön kezdeményezte a foglalást, hagyja figyelmen kívül ezt az emailt.</p>
</body>
</html>