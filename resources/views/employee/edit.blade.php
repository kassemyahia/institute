<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Edit Employee | Sho</title>
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
        <div class="d-flex align-items-center me-auto ms-3">
          <form method="POST" action="{{ route('logout') }}" class="mb-0">
            @csrf
            <button class="btn btn-outline-light btn-sm" type="submit">Logout</button>
          </form>
        </div>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
          <ul class="navbar-nav ms-auto gap-2 align-items-center">
            <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Home</a></li>
            <li class="nav-item"><a class="nav-link active" href="{{ route('employee.index') }}">Employees</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('student.index') }}">Students</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('installment.index') }}">Payments</a></li>
            <li class="nav-item"><a class="nav-link" href="#">About</a></li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="container mt-5 pt-4">
      <div class="card shadow-sm">
        <div class="card-body">
          <h4 class="card-title text-center mb-4">Edit Employee</h4>

          <form method="POST" action="{{ route('employee.update', $employee) }}">
            @csrf
            @method('PUT')
            <div class="mb-3">
              <label class="form-label">First Name</label>
              <input type="text" name="first_name" class="form-control" value="{{ old('first_name', $employee->first_name) }}" required />
            </div>

            <div class="mb-3">
              <label class="form-label">Last Name</label>
              <input type="text" name="last_name" class="form-control" value="{{ old('last_name', $employee->last_name) }}" required />
            </div>

            <div class="mb-3">
              <label class="form-label">Job Title</label>
              <input type="text" name="job_title" class="form-control" value="{{ old('job_title', $employee->job_title) }}" />
            </div>

            <div class="mb-3">
              <label class="form-label">Salary</label>
              <input type="number" min="0" name="salary" class="form-control" value="{{ old('salary', $employee->salary) }}" />
            </div>

            <div class="mb-3">
              <label class="form-label">Birth Date</label>
              <input type="date" name="birth_date" class="form-control" value="{{ old('birth_date', optional($employee->birth_date)->toDateString()) }}" />
            </div>

            <div class="text-center">
              <button class="btn btn-dark px-4" type="submit">Save</button>
              <a href="{{ route('employee.show', $employee) }}" class="btn btn-danger px-4">Cancel</a>
            </div>
          </form>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
