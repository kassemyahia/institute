<!DOCTYPE html>
<html lang="en" dir="rtl">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Add Employee | Sho</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
  </head>
  <body class="bg-light pt-5">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
          <img src="{{ asset('assets/images/logo-light.png') }}" height="40" alt="Sho" />
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
          <ul class="navbar-nav ms-auto gap-2 align-items-center">
            <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Home</a></li>
            <li class="nav-item"><a class="nav-link active" href="{{ route('employee.index') }}">Employees</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('student.index') }}">Students</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Payments</a></li>
            <li class="nav-item">
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn btn-outline-light btn-sm" type="submit">Logout</button>
              </form>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="container mt-5 pt-4">
      <div class="card shadow-sm">
        <div class="card-body">
          <h4 class="card-title text-center mb-4">نموذج إضافة مدرس</h4>

          <form method="POST" action="{{ route('employee.store') }}">
            @csrf
            <div class="mb-3">
              <label class="form-label">اسم المدرس</label>
              <input type="text" name="name" class="form-control" value="{{ old('name') }}" required />
            </div>

            <div class="mb-3">
              <label class="form-label">المادة</label>
              <input type="text" name="subject" class="form-control" value="{{ old('subject') }}" required />
            </div>

            <div class="mb-3">
              <label class="form-label">رقم الهاتف</label>
              <input type="text" name="number" class="form-control" value="{{ old('number') }}" required />
            </div>

            <div class="mb-3">
              <label class="form-label">البريد الإلكتروني</label>
              <input type="email" name="email" class="form-control" value="{{ old('email') }}" required />
            </div>

            <div class="text-center">
              <button class="btn btn-dark px-4">حفظ</button>
              <a href="{{ route('employee.index') }}" class="btn btn-danger px-4">إلغاء</a>
            </div>
          </form>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
