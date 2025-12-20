<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Add Phone Number | WebInstitute</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
  </head>
  <body class="bg-light pt-5">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
          <img src="{{ asset('assets/images/logo-light.png') }}" height="40" alt="WebInstitute" />
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
          <ul class="navbar-nav ms-auto gap-2 align-items-center">
            <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Home</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('employee.index') }}">Employees</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('student.index') }}">Students</a></li>
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
      <div class="row justify-content-center">
        <div class="col-lg-6">
          <div class="card shadow-sm">
            <div class="card-body">
              <h4 class="card-title text-center mb-4">Add Phone Number</h4>
              <form method="POST" action="{{ route('mobile_number.store') }}">
                @csrf

                <div class="mb-3">
                  <label class="form-label">Owner Type</label>
                  <select name="owner_type" class="form-select @error('owner_type') is-invalid @enderror" required>
                    <option value="">Select type</option>
                    <option value="{{ addslashes(App\Models\Student::class) }}" @selected(old('owner_type', request('owner_type')) === addslashes(App\Models\Student::class))>Student</option>
                    <option value="{{ addslashes(App\Models\Employee::class) }}" @selected(old('owner_type', request('owner_type')) === addslashes(App\Models\Employee::class))>Employee</option>
                  </select>
                  @error('owner_type')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <div class="mb-3">
                  <label class="form-label">Owner</label>
                  <select name="owner_id" class="form-select @error('owner_id') is-invalid @enderror" required>
                    <option value="">Select owner</option>
                    @foreach($students as $student)
                      <option value="{{ $student->id }}" data-type="student" @selected(old('owner_id', request('owner_id')) == $student->id && old('owner_type', request('owner_type')) === addslashes(App\Models\Student::class))>
                        Student: {{ $student->first_name }} {{ $student->last_name }}
                      </option>
                    @endforeach
                    @foreach($employees as $employee)
                      <option value="{{ $employee->id }}" data-type="employee" @selected(old('owner_id', request('owner_id')) == $employee->id && old('owner_type', request('owner_type')) === addslashes(App\Models\Employee::class))>
                        Employee: {{ $employee->first_name }} {{ $employee->last_name }}
                      </option>
                    @endforeach
                  </select>
                  @error('owner_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <div class="mb-3">
                  <label class="form-label">Phone Number</label>
                  <input type="text" name="phone_number" class="form-control @error('phone_number') is-invalid @enderror" value="{{ old('phone_number') }}" maxlength="20" required />
                  @error('phone_number')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <div class="d-flex justify-content-between">
                  <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancel</a>
                  <button type="submit" class="btn btn-dark">Save</button>
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
