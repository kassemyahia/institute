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
            <a href="{{ route('employee.create') }}" class="add-btn">+ إضافة مدرّس</a>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>الاسم</th>
                        <th>المادة</th>
                        <th>الرقم</th>
                        <th>البريد الإلكتروني</th>
                        <th>الإجراء</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($employees as $emp)
                        <tr>
                            <td>{{ $emp->id }}</td>
                            <td>{{ $emp->name }}</td>
                            <td>{{ $emp->subject }}</td>
                            <td>{{ $emp->number }}</td>
                            <td>{{ $emp->email }}</td>
                            <td><button class="view-btn">عرض</button></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>

</body>
</html>
