<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة طالب جديد</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

<header class="navbar">
    <div class="logo">إضافة طالب جديد</div>
    <div class="user-info">
        <span>{{ Auth::user()->name ?? 'زائر' }}</span>
        <a href="{{ route('employee.index') }}" class="logout">العودة</a>
    </div>
</header>

<main class="container">
    <h2 class="form-title">نموذج طالب طالب</h2>

    <form action="{{ route('student.store') }}" method="POST" class="add-form">
        @csrf
        <div class="form-group">
            <label>اسم الطالب:</label>
            <input type="text" name="first_name" placeholder="أدخل اسم الطالب" required>
        </div>

        <div class="form-group">
            <label>كنية الطالب</label>
            <input type="text" name="last_name"  required>
        </div>

        <div class="form-group">
            <label>الجنس</label>
            <input type="text" name="gender"  required>
        </div>

        <div class="form-group">
            <label>تاريخ الميلاد</label>
            <input type="date" name="birth_date" placeholder="2000-01-30" required>
        </div>

        <div class="form-buttons">
            <button type="submit" class="submit-btn">حفظ الطالب</button>
            <a href="{{ route('student.index') }}" class="cancel-btn">إلغاء</a>
        </div>
    </form>
</main>

</body>
</html>
