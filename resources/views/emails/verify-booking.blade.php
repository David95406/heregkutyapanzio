
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Foglalás Megerősítése - Héreg DTC</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, Helvetica, sans-serif; background-color: #f4f4f4; color: #333333;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td style="padding: 20px 0;">
                <table align="center" width="600" cellspacing="0" cellpadding="0" border="0" style="background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); margin: 0 auto;">
                    <!-- Fejléc -->
                    <tr>
                        <td style="background-color: #3b82f6; padding: 30px 40px; border-radius: 8px 8px 0 0; text-align: center;">
                            <h1 style="color: #ffffff; margin: 0; font-size: 28px;">Héreg DTC</h1>
                            <p style="color: #ffffff; margin: 10px 0 0 0; font-size: 18px;">Foglalás megerősítése</p>
                        </td>
                    </tr>
                    
                    <!-- Tartalom -->
                    <tr>
                        <td style="padding: 40px;">
                            <h2 style="margin-top: 0; color: #333333;">Kedves {{ $booking->name }}!</h2>
                            
                            <p style="margin-bottom: 25px; line-height: 1.5; font-size: 16px;">
                                Köszönjük, hogy a <strong>Héregi DTC-t</strong> választotta! Foglalása rendszerünkben rögzítésre került, de a véglegesítéshez kérjük, erősítse meg szándékát az alábbi gombra kattintva.
                            </p>
                            
                            <table width="100%" style="border-collapse: collapse; margin-bottom: 30px; border: 1px solid #e5e7eb;">
                                <tr>
                                    <th colspan="2" style="background-color: #f3f4f6; padding: 12px 15px; text-align: left; font-size: 18px; border-bottom: 1px solid #e5e7eb;">
                                        Foglalás részletei
                                    </th>
                                </tr>
                                <tr>
                                    <td style="padding: 12px 15px; border-bottom: 1px solid #e5e7eb;"><strong>Időszak:</strong></td>
                                    <td style="padding: 12px 15px; border-bottom: 1px solid #e5e7eb;">{{ date('Y. m. d.', strtotime($booking->start_date)) }} - {{ date('Y. m. d.', strtotime($booking->end_date)) }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px 15px; border-bottom: 1px solid #e5e7eb;"><strong>Név:</strong></td>
                                    <td style="padding: 12px 15px; border-bottom: 1px solid #e5e7eb;">{{ $booking->name }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px 15px; border-bottom: 1px solid #e5e7eb;"><strong>Email:</strong></td>
                                    <td style="padding: 12px 15px; border-bottom: 1px solid #e5e7eb;">{{ $booking->email }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px 15px; border-bottom: 1px solid #e5e7eb;"><strong>Telefonszám:</strong></td>
                                    <td style="padding: 12px 15px; border-bottom: 1px solid #e5e7eb;">{{ $booking->phone }}</td>
                                </tr>
                                @if($booking->description)
                                <tr>
                                    <td style="padding: 12px 15px;"><strong>Megjegyzés:</strong></td>
                                    <td style="padding: 12px 15px;">{{ $booking->description }}</td>
                                </tr>
                                @endif
                            </table>
                            
                            <p style="margin-bottom: 25px; line-height: 1.5; font-size: 16px;">
                                Kérjük, kattintson az alábbi gombra foglalásának megerősítéséhez. Ez a link <strong>2 napig</strong> érvényes.
                            </p>
                            
                            <!-- Megerősítő gomb -->
                            <table width="100%" cellspacing="0" cellpadding="0" border="0" style="margin-bottom: 30px;">
                                <tr>
                                    <td align="center">
                                        <a href="{{ $verificationUrl }}" style="background-color: #3b82f6; color: #ffffff; text-decoration: none; padding: 12px 30px; border-radius: 4px; font-weight: bold; display: inline-block; font-size: 16px;">Foglalás megerősítése</a>
                                    </td>
                                </tr>
                            </table>
                            
                            <p style="color: #666666; margin-bottom: 0; font-size: 14px;">
                                <strong>Fontos:</strong> Amennyiben 2 napon belül nem erősíti meg foglalását, rendszerünk automatikusan törli azt. Ha nem Ön kezdeményezte ezt a foglalást, kérjük, hagyja figyelmen kívül ezt az emailt.
                            </p>
                        </td>
                    </tr>
                    
                    <!-- Lábléc -->
                    <tr>
                        <td style="background-color: #f3f4f6; padding: 20px; border-radius: 0 0 8px 8px; text-align: center; color: #666666; font-size: 14px;">
                            <p style="margin: 0 0 10px 0;">
                                Kérdése van? Keressen minket bizalommal!
                            </p>
                            <p style="margin: 0;">
                                © {{ date('Y') }} Héreg DTC - Minden jog fenntartva
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>