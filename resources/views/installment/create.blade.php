<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Add Payment | WebInstitute</title>
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
            <li class="nav-item"><a class="nav-link active" href="{{ route('installment.index') }}">Payments</a></li>
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
              <h4 class="card-title text-center mb-4">Add Payment</h4>
              <form method="POST" action="{{ route('installment.store') }}">
                @csrf
                <div class="mb-3">
                  <label class="form-label">Student</label>
                  <select name="student_id" class="form-select @error('student_id') is-invalid @enderror" required>
                    <option value="">Select student</option>
                    @foreach($students as $student)
                      <option value="{{ $student->id }}" @selected(old('student_id', request('student_id')) == $student->id)>
                        {{ $student->first_name }} {{ $student->last_name }}
                      </option>
                    @endforeach
                  </select>
                  @error('student_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <div class="mb-3">
                  <label class="form-label">Amount Paid</label>
                  <input
                    type="number"
                    step="0.01"
                    min="0"
                    name="amount_paid"
                    value="{{ old('amount_paid') }}"
                    class="form-control @error('amount_paid') is-invalid @enderror"
                    required
                  />
                  @error('amount_paid')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <div class="mb-3">
                  <label class="form-label">Paid At</label>
                  <input
                    type="date"
                    name="paid_at"
                    value="{{ old('paid_at', now()->toDateString()) }}"
                    class="form-control @error('paid_at') is-invalid @enderror"
                  />
                  @error('paid_at')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <div class="d-flex justify-content-between">
                  <a href="{{ route('installment.index') }}" class="btn btn-secondary">Cancel</a>
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
