<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Students | Sho</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
  </head>
  <body class="bg-light pt-5">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
          <img
            src="{{ asset('assets/images/logo-light.png') }}"
            height="40"
            alt="Sho"
          />
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
          <ul class="navbar-nav ms-auto gap-2 align-items-center">
            <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Home</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('employee.index') }}">Employees</a></li>
            <li class="nav-item"><a class="nav-link active" href="{{ route('student.index') }}">Students</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('installment.index') }}">Payments</a></li>
            <li class="nav-item"><a class="nav-link" href="#">About</a></li>
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
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Students</h3>
        <a href="{{ route('student.create') }}" class="btn btn-dark">+ Add Student</a>
      </div>

      <form method="GET" action="{{ route('student.index') }}" class="mb-3">
        <div class="input-group">
          <input
            type="search"
            name="q"
            value="{{ $search ?? '' }}"
            class="form-control"
            placeholder="Search students by name or gender"
          />
          <button class="btn btn-outline-dark" type="submit">Search</button>
        </div>
      </form>

      <div class="table-responsive">
        <table class="table table-striped table-hover text-center align-middle">
          <thead class="table-dark">
            <tr>
              <th>ID</th>
              <th>First name</th>
              <th>Last name</th>
              <th>Gender</th>
              <th>Birth date</th>
              <th>Stage</th>
              <th>Full Price</th>
              <th>Paid</th>
              <th>Left</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($students as $student)
              <tr>
                <td>{{ $student->id }}</td>
                <td>{{ $student->first_name }}</td>
                <td>{{ $student->last_name }}</td>
                <td>{{ $student->gender }}</td>
                <td>{{ $student->birth_date }}</td>
                <td>{{ optional($student->stage)->name }}</td>
                <td>{{ $student->full_price }}</td>
                <td>{{ $student->total_paid ?? 0 }}</td>
                <td>{{ max(0, ($student->full_price ?? 0) - ($student->total_paid ?? 0)) }}</td>
                <td>
                  <a href="{{ route('student.show', $student) }}" class="btn btn-sm btn-outline-primary">View</a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
