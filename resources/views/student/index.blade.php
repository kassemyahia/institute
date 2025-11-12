<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة الطلاب</title>
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
    <div class="add-btn-container">
        <a href="{{ route('student.create') }}" class="add-btn">+ إضافة طالب'</a>
    </div>

    <div class="table-container">
        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>الاسم</th>
                <th>الكنية</th>
                <th>الجنس</th>
                <th>تاريخ الميلاد</th>
                <th>الإجراء</th>
            </tr>
            </thead>
            <tbody>
            @foreach($students as $stu)
                <tr>
                    <td>{{ $stu->id }}</td>
                    <td>{{ $stu->first_name }}</td>
                    <td>{{ $stu->last_name }}</td>
                    <td>{{ $stu->gender}}</td>
                    <td>{{ $stu->birth_date }}</td>
                    <td><button class="view-btn">عرض</button></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</main>

</body>
</html>
