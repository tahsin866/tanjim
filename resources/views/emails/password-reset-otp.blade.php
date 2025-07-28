<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>পাসওয়ার্ড রিসেট OTP</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #059669, #10b981);
            color: white;
            text-align: center;
            padding: 30px 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 40px 30px;
        }
        .otp-box {
            background: #f8f9fa;
            border: 2px dashed #059669;
            border-radius: 8px;
            text-align: center;
            padding: 20px;
            margin: 20px 0;
        }
        .otp-code {
            font-size: 32px;
            font-weight: bold;
            color: #059669;
            letter-spacing: 5px;
            margin: 10px 0;
        }
        .warning {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin: 20px 0;
        }
        .footer {
            background: #f8f9fa;
            text-align: center;
            padding: 20px;
            color: #666;
            font-size: 14px;
        }
        .btn {
            display: inline-block;
            background: #059669;
            color: white;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 5px;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>তানযিমে আবনায়ে ফরিদাবাদ</h1>
            <p>পাসওয়ার্ড রিসেট OTP</p>
        </div>

        <div class="content">
            <h2>প্রিয় {{ $user->fullNameBangla ?? 'ব্যবহারকারী' }},</h2>

            <p>আপনি আপনার অ্যাকাউন্টের পাসওয়ার্ড রিসেট করার জন্য অনুরোধ করেছেন। নিচের OTP কোডটি ব্যবহার করে আপনার পাসওয়ার্ড রিসেট করুন:</p>

            <div class="otp-box">
                <p style="margin: 0; color: #666;">আপনার OTP কোড:</p>
                <div class="otp-code">{{ $otp }}</div>
                <p style="margin: 0; color: #666; font-size: 14px;">এই কোড ১০ মিনিটের জন্য বৈধ</p>
            </div>

            <div class="warning">
                <strong>গুরুত্বপূর্ণ নিরাপত্তা তথ্য:</strong>
                <ul style="margin: 10px 0 0 0; padding-left: 20px;">
                    <li>এই OTP কোডটি কারো সাথে শেয়ার করবেন না</li>
                    <li>যদি আপনি এই অনুরোধ না করে থাকেন, তাহলে এই ইমেইলটি উপেক্ষা করুন</li>
                    <li>কোড ১০ মিনিটের মধ্যে ব্যবহার করুন</li>
                </ul>
            </div>

            <p>যদি আপনার কোনো সমস্যা হয়, অনুগ্রহ করে আমাদের সাথে যোগাযোগ করুন।</p>

            <p>ধন্যবাদ,<br>
            <strong>তানযিমে আবনায়ে ফরিদাবাদ টিম</strong></p>
        </div>

        <div class="footer">
            <p>এই ইমেইলটি স্বয়ংক্রিয়ভাবে পাঠানো হয়েছে। অনুগ্রহ করে এই ইমেইলের জবাব দেবেন না।</p>
            <p>&copy; {{ date('Y') }} তানযিমে আবনায়ে ফরিদাবাদ। সকল অধিকার সংরক্ষিত।</p>
        </div>
    </div>
</body>
</html>
