<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Student Details | Sho</title>
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
            <li class="nav-item"><a class="nav-link" href="{{ route('employee.index') }}">Employees</a></li>
            <li class="nav-item"><a class="nav-link active" href="{{ route('student.index') }}">Students</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('installment.index') }}">Payments</a></li>
            <li class="nav-item"><a class="nav-link" href="#">About</a></li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="container mt-5 pt-4">
      <div class="row justify-content-center">
        <div class="col-lg-8 col-xl-7">
          <div class="card shadow-sm">
            <div class="card-body">
              <h4 class="card-title text-center mb-4">Student Details</h4>

              <ul class="list-group list-group-flush mb-3">
                <li class="list-group-item d-flex justify-content-between">
                  <strong>First Name</strong>
                  <span>{{ $student->first_name }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                  <strong>Last Name</strong>
                  <span>{{ $student->last_name }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                  <strong>Gender</strong>
                  <span>{{ $student->gender }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                  <strong>Birth Date</strong>
                  <span>{{ optional($student->birth_date)->toDateString() }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                  <strong>Registration Date</strong>
                  <span>{{ optional($student->registration_date)->toDateString() }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                  <strong>Section</strong>
                  <span>{{ optional($student->section)->name }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                  <strong>Stage</strong>
                  <span>{{ optional($student->stage)->name }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                  <strong>Fully Paid?</strong>
                  <span class="{{ $student->is_fully_paid ? 'text-success' : 'text-danger' }}">
                    {{ $student->is_fully_paid ? 'Yes' : 'No' }}
                  </span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                  <strong>Full Price</strong>
                  <span>{{ $student->full_price }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                  <strong>Total Paid</strong>
                  <span>{{ $totalPaid }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                  <strong>Amount Left</strong>
                  <span>{{ $amountLeft }}</span>
                </li>
              </ul>

              <div class="mb-3">
                <h6 class="mb-2">Subjects & Grades</h6>
                @forelse($student->grades as $grade)
                  <div class="d-flex justify-content-between border rounded px-3 py-2 mb-2">
                    <span>{{ optional($grade->subject)->name }}</span>
                    <span class="fw-bold">{{ $grade->score }}</span>
                  </div>
                @empty
                  <p class="text-muted">No grades yet.</p>
                @endforelse
              </div>

              <div class="mb-3">
                <h6 class="mb-2">Payments</h6>
                @forelse($student->installments as $installment)
                  <div class="d-flex justify-content-between border rounded px-3 py-2 mb-2">
                    <span>{{ $installment->paid_at->toDateString() }}</span>
                    <span class="fw-bold">{{ $installment->amount_paid }}</span>
                  </div>
                @empty
                  <p class="text-muted">No payments.</p>
                @endforelse
              </div>

              <div class="mb-3">
                <h6 class="mb-2">Phone Numbers</h6>
                @forelse($student->mobileNumbers as $number)
                  <div class="border rounded px-3 py-2 mb-2">{{ $number->phone_number }}</div>
                @empty
                  <p class="text-muted">No numbers.</p>
                @endforelse
                <a href="{{ route('mobile_number.create', ['owner_type' => addslashes(App\Models\Student::class), 'owner_id' => $student->id]) }}" class="btn btn-sm btn-outline-primary mt-2">Add Phone Number</a>
              </div>

              <div class="text-center mt-4">
                <a href="{{ route('student.edit', $student) }}" class="btn btn-dark px-4 me-2">Edit</a>
                <a href="{{ route('installment.create', ['student_id' => $student->id]) }}" class="btn btn-outline-primary px-4 me-2">Add Payment</a>
                <a href="{{ route('student.index') }}" class="btn btn-secondary px-4">Back</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
