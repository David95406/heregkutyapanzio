<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Foglalási adatok módosítása</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            background-color: #f9f9f9;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 0 0 5px 5px;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #777;
        }
        .booking-info {
            background-color: white;
            padding: 15px;
            margin-top: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .field-name {
            font-weight: bold;
            color: #555;
        }
        .highlight {
            background-color: #ffffcc;
            padding: 2px 5px;
            border-radius: 3px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Foglalási adatok módosítása</h2>
        </div>
        
        <div class="content">
            <p>Tisztelt {{ $booking->name }}!</p>
            
            <p>Ezúton tájékoztatjuk, hogy foglalásának adatai módosításra kerültek a Héreg Kutyapanzió rendszerében.</p>
            
            <p>A módosított mező: <span class="highlight">{{ $updatedField == 'start_date' ? 'Kezdő dátum' : ($updatedField == 'end_date' ? 'Befejező dátum' : 'Megjegyzés') }}</span></p>
            
            <div class="booking-info">
                <h3>Foglalás részletei:</h3>
                <p><span class="field-name">Név:</span> {{ $booking->name }}</p>
                <p><span class="field-name">Email:</span> {{ $booking->email }}</p>
                <p><span class="field-name">Telefonszám:</span> {{ $booking->phone }}</p>
                <p><span class="field-name">Kezdő dátum:</span> {{ date('Y. m. d. H:i', strtotime($booking->start_date)) }}</p>
                <p><span class="field-name">Befejező dátum:</span> {{ date('Y. m. d. H:i', strtotime($booking->end_date)) }}</p>
                
                @if($booking->description)
                    <p><span class="field-name">Megjegyzés:</span> {{ $booking->description }}</p>
                @endif
                
            </div>
            
            <p>Ha bármilyen kérdése van a foglalással kapcsolatban, kérjük vegye fel velünk a kapcsolatot az alábbi elérhetőségek egyikén:</p>
            <p>Telefon: +36 20 123 4567<br>
            Email: info@heregkutyapanzio.hu</p>
            
            <p>Köszönjük, hogy minket választott!</p>
            
            <p>Üdvözlettel,<br>
            Héreg Kutyapanzió csapata</p>
        </div>
        
        <div class="footer">
            <p>Ez egy automatikus üzenet, kérjük ne válaszoljon rá.</p>
        </div>
    </div>
</body>
</html>