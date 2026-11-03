<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Mã Xác Nhận Đăng Ký Tài Khoản ChronoLux</title>
</head>
<body style="margin: 0; padding: 0; background-color: #020617; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; color: #f8fafc;">
    <table role="presentation" width="100%" border="0" cellspacing="0" cellpadding="0" style="background-color: #020617; padding: 40px 20px;">
        <tr>
            <td align="center">
                <!-- Main Email Card -->
                <table role="presentation" width="100%" border="0" cellspacing="0" cellpadding="0" style="max-width: 580px; background-color: #0f172a; border: 1px solid #1e293b; border-radius: 20px; overflow: hidden; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.5);">
                    
                    <!-- Top Gold Gradient Accent Line -->
                    <tr>
                        <td style="height: 4px; background: linear-gradient(90deg, #c69225, #f59e0b, #c69225);"></td>
                    </tr>

                    <!-- Header with Logo -->
                    <tr>
                        <td align="center" style="padding: 35px 30px 20px 30px; border-bottom: 1px solid #1e293b;">
                            <div style="font-size: 26px; font-weight: 800; letter-spacing: 4px; color: #f59e0b; text-transform: uppercase;">CHRONOLUX</div>
                            <div style="font-size: 9px; letter-spacing: 3px; color: #94a3b8; text-transform: uppercase; margin-top: 4px;">Haute Horlogerie • Est. 2012</div>
                        </td>
                    </tr>

                    <!-- Email Body -->
                    <tr>
                        <td style="padding: 35px 30px;">
                            <h1 style="font-size: 20px; font-weight: 700; color: #ffffff; margin: 0 0 16px 0;">Kính chào quý khách {{ $user->name }},</h1>
                            
                            <p style="font-size: 14px; line-height: 24px; color: #cbd5e1; margin: 0 0 20px 0;">
                                Cảm ơn quý khách đã tin tưởng và đăng ký tài khoản thành viên tại <strong>ChronoLux</strong>. Để hoàn tất việc xác thực email và kích hoạt tài khoản mua sắm, quý khách vui lòng sử dụng mã xác nhận bên dưới:
                            </p>

                            <!-- Big OTP Code Box -->
                            <div style="background-color: #020617; border: 1px solid #334155; border-radius: 14px; padding: 24px; text-align: center; margin: 25px 0;">
                                <div style="font-size: 11px; text-transform: uppercase; letter-spacing: 2px; color: #94a3b8; margin-bottom: 8px;">Mã xác thực của quý khách:</div>
                                <div style="font-size: 36px; font-weight: 800; letter-spacing: 10px; color: #f59e0b; font-family: monospace;">{{ $code }}</div>
                                <div style="font-size: 12px; color: #64748b; margin-top: 8px;">Mã có hiệu lực trong vòng <strong>15 phút</strong></div>
                            </div>

                            <!-- 1-Click Verification Button -->
                            <div style="text-align: center; margin: 30px 0 20px 0;">
                                <a href="{{ $verifyUrl }}" target="_blank" style="display: inline-block; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: #020617; font-weight: bold; font-size: 14px; padding: 14px 32px; border-radius: 12px; text-decoration: none; text-transform: uppercase; letter-spacing: 1px; box-shadow: 0 10px 15px -3px rgba(245, 158, 11, 0.3);">
                                    XÁC THỰC 1 CHẠM NGAY
                                </a>
                                <p style="font-size: 11px; color: #64748b; margin-top: 10px;">(Hoặc quý khách có thể copy mã 6 số ở trên và nhập tại trang web)</p>
                            </div>

                            <p style="font-size: 13px; line-height: 20px; color: #94a3b8; margin: 25px 0 0 0; padding-top: 20px; border-top: 1px solid #1e293b;">
                                ⚠️ Nếu quý khách không thực hiện yêu cầu đăng ký này, xin vui lòng bỏ qua email. Tài khoản sẽ tự động bị hủy nếu không được xác thực.
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td align="center" style="background-color: #020617; padding: 25px 30px; border-top: 1px solid #1e293b; color: #64748b; font-size: 12px;">
                            <div style="font-weight: 600; color: #cbd5e1; margin-bottom: 4px;">ChronoLux Luxury Watches & Haute Horlogerie</div>
                            <div>Hotline hỗ trợ khách hàng: <strong style="color: #f59e0b;">1900 8888</strong> • Giờ làm việc: 8:00 - 22:00</div>
                            <div style="margin-top: 8px; font-size: 11px; color: #475569;">© 2026 ChronoLux. All rights reserved.</div>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
