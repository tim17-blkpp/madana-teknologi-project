<!DOCTYPE html>
<html>
<head>
    <title>New Contact Form Submission</title>
</head>
<body>
    <p><strong>Name:</strong> {{ $contactForm['name'] }}</p>
    <p><strong>Email:</strong> {{ $contactForm['email'] }}</p>
    <p><strong>Phone:</strong> {{ $contactForm['phone'] }}</p>
    <p><strong>Message:</strong> {{ $contactForm['message'] }}</p>
</body>
</html>
