<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Új Megerősített Foglalás</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f6f6f6;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header {
            background-color: #4f46e5;
            padding: 20px;
            text-align: center;
            color: white;
            border-radius: 8px 8px 0 0;
            margin: -20px -20px 20px;
        }
        .booking-info {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }
        th {
            background-color: #f1f5f9;
        }
        .actions {
            text-align: center;
            margin-top: 20px;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4f46e5;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 0 10px;
        }
        .verified-badge {
            display: inline-block;
            background-color: #10b981;
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Új Megerősített Foglalás</h1>
            <p>Héreg Kutyapanzió</p>
        </div>
        
        <p>Tisztelt Adminisztrátor!</p>
        
        <p>Új foglalás érkezett, amelyet a vendég sikeresen megerősített az email címén keresztül.</p>
        
        <div class="booking-info">
            <h3>Foglalási adatok <span class="verified-badge">Megerősítve</span></h3>
            
            <table>
                <tr>
                    <th>Azonosító</th>
                    <td>{{ $booking->id }}</td>
                </tr>
                <tr>
                    <th>Név</th>
                    <td>{{ $booking->name }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $booking->email }}</td>
                </tr>
                <tr>
                    <th>Telefonszám</th>
                    <td>{{ $booking->phone }}</td>
                </tr>
                <tr>
                    <th>Érkezés</th>
                    <td>{{ date('Y. m. d.', strtotime($booking->start_date)) }}</td>
                </tr>
                <tr>
                    <th>Távozás</th>
                    <td>{{ date('Y. m. d.', strtotime($booking->end_date)) }}</td>
                </tr>
                <tr>
                    <th>Időtartam</th>
                    <td>{{ \Carbon\Carbon::parse($booking->start_date)->diffInDays(\Carbon\Carbon::parse($booking->end_date)) }} nap</td>
                </tr>
                <tr>
                    <th>Megerősítve</th>
                    <td>{{ date('Y. m. d. H:i', strtotime($booking->verified_at)) }}</td>
                </tr>
                @if($booking->description)
                <tr>
                    <th>Megjegyzés</th>
                    <td>{{ $booking->description }}</td>
                </tr>
                @endif
            </table>
        </div>
        
        <p>Kérjük, ellenőrizze és kezelje a foglalást az admin felületen.</p>
        
        <div class="actions">
            <a href="{{ route('admin.index') }}" class="button">Admin felület megnyitása</a>
        </div>
        
        <p style="margin-top: 30px; font-size: 12px; color: #64748b; text-align: center;">
            Ez egy automatikus értesítés, amely a Héreg Kutyapanzió foglalási rendszeréből érkezett.
        </p>
    </div>
</body>
</html>