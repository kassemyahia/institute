<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Employee Details | Sho</title>
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
      <div class="row justify-content-center">
        <div class="col-lg-6">
          <div class="card shadow-sm">
              <div class="card-body">
                <h4 class="card-title text-center mb-4">Employee Details</h4>

              <ul class="list-group list-group-flush">
                <li class="list-group-item d-flex justify-content-between">
                  <strong>First Name</strong>
                  <span>{{ $employee->first_name }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                  <strong>Last Name</strong>
                  <span>{{ $employee->last_name }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                  <strong>Job Title</strong>
                  <span>{{ $employee->job_title }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                  <strong>Salary</strong>
                  <span>{{ $employee->salary }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                  <strong>Birth Date</strong>
                  <span>{{ $employee->birth_date }}</span>
                </li>
                <li class="list-group-item">
                  <strong class="d-block mb-2">Subjects</strong>
                  @forelse($employee->subjects as $subject)
                    <span class="badge bg-primary me-1">{{ $subject->name }}</span>
                  @empty
                    <span class="text-muted">No subjects</span>
                  @endforelse
                </li>
                <li class="list-group-item">
                  <strong class="d-block mb-2">Phone Numbers</strong>
                  @forelse($employee->mobileNumbers as $number)
                    <div>{{ $number->phone_number }}</div>
                  @empty
                    <span class="text-muted">No numbers</span>
                  @endforelse
                </li>
              </ul>

              <div class="text-center mt-4">
                <a href="{{ route('employee.edit', $employee) }}" class="btn btn-dark px-4 me-2">Edit</a>
                <a href="{{ route('mobile_number.create', ['owner_type' => addslashes(App\Models\Employee::class), 'owner_id' => $employee->id]) }}" class="btn btn-outline-primary px-4 me-2">Add Phone Number</a>
                <a href="{{ route('employee.index') }}" class="btn btn-secondary px-4">Back</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
