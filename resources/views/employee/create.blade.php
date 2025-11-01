<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة مدرس جديد</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

<header class="navbar">
    <div class="logo">إضافة مدرس جديد</div>
    <div class="user-info">
        <span>{{ Auth::user()->name ?? 'زائر' }}</span>
        <a href="{{ route('employee.index') }}" class="logout">العودة</a>
    </div>
</header>

<main class="container">
    <h2 class="form-title">نموذج إضافة مدرس</h2>

    <form action="{{ route('employee.store') }}" method="POST" class="add-form">
        @csrf
        <div class="form-group">
            <label>اسم المدرس:</label>
            <input type="text" name="name" placeholder="أدخل اسم المدرس" required>
        </div>

        <div class="form-group">
            <label>المادة التي يدرّسها:</label>
            <input type="text" name="subject" placeholder="مثال: رياضيات، فيزياء..." required>
        </div>

        <div class="form-group">
            <label>رقم الهاتف:</label>
            <input type="text" name="number" placeholder="أدخل رقم الهاتف" required>
        </div>

        <div class="form-group">
            <label>البريد الإلكتروني:</label>
            <input type="email" name="email" placeholder="example@email.com" required>
        </div>

        <div class="form-buttons">
            <button type="submit" class="submit-btn">حفظ المدرس</button>
            <a href="{{ route('employee.index') }}" class="cancel-btn">إلغاء</a>
        </div>
    </form>
</main>

</body>
</html>
