<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Email Confirmation</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
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
            font-family: 'Montserrat', 'Helvetica Neue', Helvetica, Arial, sans-serif;
        }

        .email-wrap {
            width: 100%;
            padding: 24px 8px;
            background: #f7f7f7;
        }

        .email-inner {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 10px;
            overflow: hidden;
        }

        /* Typography */
        .h1 {
            font-size: 24px;
            font-weight: 700;
            margin: 0 0 12px 0;
            color: #111;
        }

        .p {
            font-size: 15px;
            line-height: 1.6;
            color: #333;
            margin: 0 0 16px 0;
        }

        .muted {
            color: #888;
            font-size: 13px;
        }

        /* Buttons */
        .btn {
            display: inline-block;
            padding: 14px 26px;
            border-radius: 28px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            font-size: 13px;
        }

        .btn-primary {
            background: #111;
            color: #fff;
        }

        /* Divider */
        .divider {
            height: 1px;
            background: #f1f1f1;
            margin: 24px 0;
        }

        /* Footer */
        .footer {
            font-size: 12px;
            color: #9b9b9b;
            padding: 18px;
            text-align: center;
        }

        @media only screen and (max-width:520px) {
            .h1 {
                font-size: 20px;
            }

            .btn {
                padding: 12px 20px;
                font-size: 13px;
            }

            .email-inner {
                border-radius: 0;
            }
        }
    </style>
</head>

<body>

    <!-- Preheader (shown in inbox preview) -->
    <span
        style="display:none; font-size:1px; color:#ffffff; line-height:1px; max-height:0px; max-width:0px; opacity:0; overflow:hidden;">
        Confirm your email to complete your registration.
    </span>

    <table class="email-wrap" width="100%" cellpadding="0" cellspacing="0" role="presentation">
        <tr>
            <td align="center">
                <table class="email-inner" width="600" cellpadding="0" cellspacing="0" role="presentation">

                    <!-- ✅ Premium Black Header -->
                    <tr>
                        <td style="background:#000; padding:20px 32px;">
                            <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                <tr>
                                    <!-- Left: Logo -->
                                    <td style="text-align:left;">
                                        <img src="https://saicabtech.com/wp-content/uploads/2023/03/high-quality-system.png"
                                            alt="Logo" width="120" style="display:block;">
                                    </td>
                                    <!-- Right: Company Name -->
                                    <td style="text-align:right; vertical-align:middle;">
                                        <span
                                            style="color:#fff; font-size:14px; font-weight:600; letter-spacing:0.5px;">
                                            Zero What
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td style="padding:32px;">
                            <h1 class="h1">Confirm your email address</h1>
                            <p class="p">
                                Hi <strong>John</strong>, thank you for signing up!
                                To complete your registration and start exploring, please confirm your email address by
                                clicking the button below.
                            </p>

                            <table cellpadding="0" cellspacing="0" role="presentation" style="margin-top:24px;">
                                <tr>
                                    <td>
                                        <a href="https://example.com/confirm?token=abc123"
                                            class="btn btn-primary">Confirm Email</a>
                                    </td>
                                </tr>
                            </table>

                            <p class="p" style="margin-top:28px;">
                                If the button doesn’t work, copy and paste this link into your browser:
                            </p>
                            <p class="p" style="word-break:break-all; font-size:13px; color:#555;">
                                <a href="https://example.com/confirm?token=abc123" style="color:#555;">
                                    https://example.com/confirm?token=abc123
                                </a>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:16px 32px 24px 32px; background:#fafafa;">
                            <div class="footer">
                                <p style="margin:0 0 8px 0;">Need help? <a href="mailto:support@example.com"
                                        style="color:#9b9b9b; text-decoration:underline;">Contact support</a></p>
                                <p style="margin:0;">© 2025 Nike Sports Inc. All rights reserved.</p>
                            </div>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>

</html>