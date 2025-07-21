<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Foglalási kérelem válasza - Hereg Kutyapanzió</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, Helvetica, sans-serif; background-color: #f4f4f4; color: #333333;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td style="padding: 20px 0;">
                <table align="center" width="600" cellspacing="0" cellpadding="0" border="0" style="background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); margin: 0 auto;">
                    <!-- Fejléc -->
                    <tr>
                        <td style="background-color: #4b5563; padding: 30px 40px; border-radius: 8px 8px 0 0; text-align: center;">
                            <h1 style="color: #ffffff; margin: 0; font-size: 28px;">Hereg Kutyapanzió</h1>
                            <p style="color: #ffffff; margin: 10px 0 0 0; font-size: 18px;">Foglalási kérelem válasza</p>
                        </td>
                    </tr>
                    
                    <!-- Tartalom -->
                    <tr>
                        <td style="padding: 40px;">
                            <h2 style="margin-top: 0; color: #333333;">Kedves {{ $booking->name }}!</h2>
                            
                            <p style="margin-bottom: 25px; line-height: 1.5; font-size: 16px;">
                                Köszönjük érdeklődését a Hereg Kutyapanzió szolgáltatásai iránt. Sajnálattal tájékoztatjuk, hogy az alábbi időpontra vonatkozó foglalási kérelmét jelenleg nem áll módunkban elfogadni.
                            </p>
                            
                            <table width="100%" style="border-collapse: collapse; margin-bottom: 30px; border: 1px solid #e5e7eb;">
                                <tr>
                                    <th colspan="2" style="background-color: #f3f4f6; padding: 12px 15px; text-align: left; font-size: 18px; border-bottom: 1px solid #e5e7eb;">
                                        Foglalás részletei
                                    </th>
                                </tr>
                                <tr>
                                    <td style="padding: 12px 15px; border-bottom: 1px solid #e5e7eb; width: 40%;"><strong>Időszak:</strong></td>
                                    <td style="padding: 12px 15px; border-bottom: 1px solid #e5e7eb;">{{ date('Y. m. d.', strtotime($booking->start_date)) }} - {{ date('Y. m. d.', strtotime($booking->end_date)) }}</td>
                                </tr>
                            </table>
                            
                            <p style="margin-bottom: 25px; line-height: 1.5; font-size: 16px;">
                                Ennek lehetséges okai az alábbiak lehetnek:
                            </p>
                            
                            <ul style="margin-bottom: 25px; line-height: 1.5; font-size: 16px;">
                                <li>A kért időszakban panzióink teljes kapacitással működnek</li>
                                <li>Váratlan technikai vagy személyzeti problémák miatt nem tudunk fogadni vendégeket</li>
                                <li>A megadott időszakban különleges esemény vagy karbantartás van panzióinkban</li>
                            </ul>
                            
                            <p style="margin-bottom: 25px; line-height: 1.5; font-size: 16px;">
                                Javasoljuk, hogy próbálkozzon egy másik időpontban, vagy vegye fel velünk a kapcsolatot telefonon az alternatív lehetőségek megbeszélése céljából.
                            </p>
                            
                            <p style="margin-bottom: 25px; line-height: 1.5; font-size: 16px;">
                                Nagyon sajnáljuk a kellemetlenséget, és reméljük, hogy egy későbbi időpontban lesz lehetőségünk fogadni Önt és kedvencét.
                            </p>
                            
                            <p style="color: #4b5563; margin-bottom: 0; font-size: 16px; font-weight: bold;">
                                Köszönjük megértését!
                            </p>
                        </td>
                    </tr>
                    
                    <!-- Lábléc -->
                    <tr>
                        <td style="background-color: #f3f4f6; padding: 20px; border-radius: 0 0 8px 8px; text-align: center; color: #666666; font-size: 14px;">
                            <p style="margin: 0 0 10px 0;">
                                <strong>Hereg Kutyapanzió</strong><br>
                                Telefon: +36 20 123 4567<br>
                                Email: info@heregkutyapanzio.hu
                            </p>
                            <p style="margin: 0;">
                                © {{ date('Y') }} Hereg Kutyapanzió - Minden jog fenntartva
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>