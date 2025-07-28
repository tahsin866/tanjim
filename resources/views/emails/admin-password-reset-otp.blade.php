<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>এডমিন পাসওয়ার্ড রিসেট OTP</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .email-container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #2563eb;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #2563eb;
            margin: 0;
            font-size: 28px;
        }
        .header p {
            color: #666;
            margin: 5px 0 0 0;
            font-size: 16px;
        }
        .otp-section {
            text-align: center;
            margin: 30px 0;
            padding: 25px;
            background-color: #f8fafc;
            border-radius: 8px;
            border: 2px dashed #2563eb;
        }
        .otp-code {
            font-size: 36px;
            font-weight: bold;
            color: #dc2626;
            letter-spacing: 5px;
            margin: 15px 0;
            font-family: 'Courier New', monospace;
        }
        .content {
            font-size: 16px;
            line-height: 1.8;
            margin-bottom: 20px;
        }
        .warning {
            background-color: #fef2f2;
            border-left: 4px solid #dc2626;
            padding: 15px;
            margin: 25px 0;
            border-radius: 4px;
        }
        .warning h3 {
            color: #dc2626;
            margin: 0 0 10px 0;
            font-size: 18px;
        }
        .warning p {
            margin: 0;
            color: #7f1d1d;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            color: #6b7280;
            font-size: 14px;
        }
        .admin-badge {
            display: inline-block;
            background-color: #dc2626;
            color: white;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <div class="admin-badge">এডমিন প্যানেল</div>
            <h1>তানযিমে আবনায়ে ফরিদাবাদ</h1>
            <p>ওয়ার্ক ম্যানেজমেন্ট সিস্টেম</p>
        </div>

        <div class="content">
            <p>আসসালামু আলাইকুম,</p>
            <p><strong>{{ $admin->name ?? 'এডমিন' }}</strong> সাহেব,</p>
            <p>আপনি আপনার এডমিন অ্যাকাউন্টের পাসওয়ার্ড রিসেট করার জন্য অনুরোধ করেছেন। নিচের OTP কোড ব্যবহার করে আপনার পাসওয়ার্ড রিসেট প্রক্রিয়া সম্পন্ন করুন:</p>
        </div>

        <div class="otp-section">
            <h2 style="margin: 0 0 10px 0; color: #2563eb;">আপনার OTP কোড</h2>
            <div class="otp-code">{{ $otp }}</div>
            <p style="margin: 10px 0 0 0; color: #666; font-size: 14px;">এই কোডটি ১০ মিনিটের জন্য বৈধ</p>
        </div>

        <div class="content">
            <p>এই OTP কোডটি ব্যবহার করে আপনার নতুন পাসওয়ার্ড সেট করুন। পাসওয়ার্ড রিসেট সম্পন্ন হওয়ার পর এই কোডটি আর ব্যবহার করা যাবে না।</p>
        </div>

        <div class="warning">
            <h3>⚠️ নিরাপত্তা সতর্কতা</h3>
            <p><strong>এই OTP কোড কারো সাথে শেয়ার করবেন না।</strong> যদি আপনি এই পাসওয়ার্ড রিসেটের অনুরোধ না করে থাকেন, তাহলে অবিলম্বে সিস্টেম অ্যাডমিনিস্ট্রেটরের সাথে যোগাযোগ করুন এবং এই ইমেইলটি উপেক্ষা করুন।</p>
        </div>

        <div class="footer">
            <p>ধন্যবাদ,<br>
            <strong>তানযিমে আবনায়ে ফরিদাবাদ</strong><br>
            ওয়ার্ক ম্যানেজমেন্ট সিস্টেম টিম</p>
            <p style="margin-top: 15px; font-size: 12px;">
                এটি একটি স্বয়ংক্রিয় ইমেইল। এই ইমেইলের উত্তর দেবেন না।
            </p>
        </div>
    </div>
</body>
</html>
