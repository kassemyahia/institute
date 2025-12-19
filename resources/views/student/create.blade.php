<!DOCTYPE html>
<html lang="en" dir="rtl">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Add Student | Sho</title>
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
            <li class="nav-item"><a class="nav-link" href="{{ route('employee.index') }}">Employees</a></li>
            <li class="nav-item"><a class="nav-link active" href="{{ route('student.index') }}">Students</a></li>
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
      <div class="row justify-content-center">
        <div class="col-lg-6">
          <div class="card shadow-sm">
            <div class="card-body">
              <h4 class="card-title text-center mb-4">نموذج إضافة طالب</h4>

              <form method="POST" action="{{ route('student.store') }}">
                @csrf
                <div class="mb-3">
                  <label class="form-label">اسم الطالب</label>
                  <input type="text" name="first_name" class="form-control" value="{{ old('first_name') }}" required />
                </div>

                <div class="mb-3">
                  <label class="form-label">كنية الطالب</label>
                  <input type="text" name="last_name" class="form-control" value="{{ old('last_name') }}" required />
                </div>

                <div class="mb-3">
                  <label class="form-label">الجنس</label>
                  <select class="form-select" name="gender" required>
                    <option value="">اختر الجنس</option>
                    <option value="male" @selected(old('gender') === 'male')>ذكر</option>
                    <option value="female" @selected(old('gender') === 'female')>أنثى</option>
                  </select>
                </div>

                <div class="mb-3">
                  <label class="form-label">تاريخ الميلاد</label>
                  <input type="date" name="birth_date" class="form-control" value="{{ old('birth_date') }}" required />
                </div>

                <div class="text-center">
                  <button class="btn btn-dark px-4">حفظ الطالب</button>
                  <a href="{{ route('student.index') }}" class="btn btn-danger px-4">إلغاء</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
