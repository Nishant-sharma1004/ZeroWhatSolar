<html lang="en">

<head>
    <meta charset="utf-8">
    <title>New Solar Inquiry</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&amp;display=swap" rel="stylesheet">
    <style>
        body,
        table,
        td,
        a {
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }

        table,
        td {
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }

        img {
            -ms-interpolation-mode: bicubic;
            border: 0;
            outline: none;
            text-decoration: none;
            display: block;
            width: 40px;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        body {
            margin: 0;
            padding: 0;
            background: #f7f7f7;
            font-family: 'Montserrat', Helvetica, Arial, sans-serif;
        }

        .email-wrap {
            width: 100%;
            padding: 24px 8px;
            background: #f7f7f7;
        }

        .email-inner {
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
        }

        .h1 {
            font-size: 24px;
            font-weight: 700;
            margin: 0 0 12px;
            color: #111;
        }

        .p {
            font-size: 15px;
            line-height: 1.6;
            color: #333;
            margin: 0 0 16px;
        }

        .footer {
            font-size: 12px;
            color: #9b9b9b;
            padding: 18px;
            text-align: center;
        }

        table.details {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
        }

        table.details td {
            padding: 8px 0;
            border-bottom: 1px solid #eee;
            font-size: 14px;
        }

        table.details td:first-child {
            font-weight: 600;
            color: #000;
            width: 40%;
        }

        @media only screen and (max-width:520px) {
            .h1 {
                font-size: 20px;
            }

            .email-inner {
                border-radius: 0;
            }
        }
    </style>
</head>

<body>
    <table class="email-wrap" width="100%" cellpadding="0" cellspacing="0">
        <tbody>
            <tr>
                <td align="center">
                    <table class="email-inner" width="600" cellpadding="0" cellspacing="0">

                        <!-- ✅ Existing Header -->
                        <tbody>
                            <tr>
                                <td style="background:#000; padding:20px 32px;">
                                    <table width="100%">
                                        <tbody>
                                            <tr>
                                                <td style="text-align:left;">
                                                    <img src="https://saicabtech.com/wp-content/uploads/2023/03/high-quality-system.png"
                                                        alt="Logo" width="120">
                                                </td>
                                                <td style="text-align:right; vertical-align:middle;">
                                                    <span
                                                        style="color:#fff; font-size:14px; font-weight:600; letter-spacing:0.5px;">
                                                        Zero What
                                                    </span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>

                            <!-- 🌞 Updated Content -->
                            <tr>
                                <td style="padding:32px;">
                                    <h1 class="h1">New Solar Inquiry Received</h1>
                                    <p class="p">A new solar inquiry has been submitted from your website. Here are the
                                        details:</p>

                                    <table class="details">
                                        <tbody>
                                            <tr>
                                                <td>Name:</td>
                                                <td><?php echo $name; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Email:</td>
                                                <td><?php echo $email; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Phone:</td>
                                                <td><?php echo $phone; ?></td>
                                            </tr>
                                            <?php if (isset($property_type)) { ?>
                                                <tr>
                                                    <td>Property Type:</td>
                                                    <td><?php echo $property_type; ?></td>
                                                </tr>
                                            <?php }
                                            if (isset($monthly_bill)) { ?>
                                                <tr>
                                                    <td>Monthly Bill:</td>
                                                    <td>₹<?php echo $monthly_bill; ?></td>
                                                </tr>
                                            <?php }
                                            if (isset($address)) { ?>
                                                <tr>
                                                    <td>Address:</td>
                                                    <td><?php echo $address; ?></td>
                                                </tr>
                                            <?php }
                                            if (isset($whatsapp_updates)) { ?>
                                                <tr>
                                                    <td>WhatsApp Updates:</td>
                                                    <td><?php echo $whatsapp_updates; ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                    <?php if (isset($message)) { ?>
                                        <p class="p" style="margin-top:20px;">
                                            <strong>Message:</strong><br><?php echo $message; ?>
                                        </p>
                                    <?php } ?>
                                    <div style="margin-top:24px; border-top:1px solid #eee; padding-top:16px;">
                                        <p class="p"><strong>Lead Score:</strong> <?php echo $lead_score; ?>/7</p>
                                        <p class="p" style="color:<?php echo $priority_color; ?>; font-weight:600;">
                                            <?php echo $priority_text; ?>
                                        </p>
                                        <p class="p" style="font-size:13px; color:#666;">
                                            Submitted on: <?php echo date('Y-m-d H:i:s'); ?><br>
                                            Source: Zero What Solar Website
                                        </p>
                                    </div>
                                </td>
                            </tr>

                            <!-- ✅ Existing Footer -->
                            <tr>
                                <td style="padding:16px 32px 24px 32px; background:#fafafa;">
                                    <div class="footer">
                                        <p style="margin:0 0 8px;">Need help?
                                            <a href="mailto:support@zerowhatsolar.in"
                                                style="color:#9b9b9b; text-decoration:underline;">Contact support</a>
                                        </p>
                                        <p style="margin:0;">© <?php echo date('Y'); ?> Zero What Solar. All rights
                                            reserved.</p>
                                    </div>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>