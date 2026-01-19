<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Winner Notification</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #333333;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .email-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 40px 20px;
            text-align: center;
        }
        .email-body {
            padding: 40px 30px;
        }
        .email-body p {
            margin: 0 0 20px 0;
            font-size: 16px;
            line-height: 1.8;
        }
        .logo-container {
            text-align: center;
            margin: 30px 0;
        }
        .logo-container img {
            max-width: 200px;
            height: auto;
        }
        .email-footer {
            background-color: #f8f9fa;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #e9ecef;
        }
        .email-footer p {
            margin: 5px 0;
            font-size: 13px;
            color: #6c757d;
        }
        .email-footer a {
            color: #667eea;
            text-decoration: none;
        }
        .email-footer a:hover {
            text-decoration: underline;
        }
        .greeting {
            font-size: 18px;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 20px;
        }
        .signature {
            font-style: italic;
            color: #4a5568;
            margin-top: 30px;
        }
        .message-content {
            white-space: pre-wrap;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <!-- Header space for branding -->
        </div>
        
        <div class="email-body">
            <div class="message-content">
                {!! nl2br(e($body)) !!}
            </div>
            
            <div class="logo-container">
                <img src="{{ asset('images/logo.png') }}" alt="Curl AFhair Logo">
            </div>
        </div>
        
        <div class="email-footer">
            <p><strong>Curl AFhair</strong> is a brand and registered trademark of Planet AF Enterprises</p>
            <p>
                <a href="mailto:hello@curlafhair.com">hello@curlafhair.com</a> | 
                <a href="https://www.curlafhair.com" target="_blank">www.curlafhair.com</a>
            </p>
        </div>
    </div>
</body>
</html>
