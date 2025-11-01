<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

<header class="navbar">
    <div class="logo">لوحة التحكم</div>
    <div class="user-info">
        <span>{{ Auth::user()->name ?? 'زائر' }}</span>
        <a href="{{ route('logout') }}" class="logout">تسجيل الخروج</a>
    </div>
</header>

<main class="container">
    <h2 class="dashboard-title">مرحباً بك في لوحة الإدارة</h2>

    <div class="dashboard-buttons">
        <a href="{{ route('employee.index') }}" class="dashboard-btn">👨‍🏫 إدارة المدرسين</a>
        <a href="#" class="dashboard-btn">👨‍🎓 إدارة الطلاب</a>
        <a href="#" class="dashboard-btn">💰 إدارة أقساط الطلاب</a>
    </div>
</main>

</body>
</html>
