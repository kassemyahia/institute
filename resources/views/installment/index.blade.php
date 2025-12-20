<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Payments | WebInstitute</title>
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
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Payments</h3>
        <a href="{{ route('installment.create') }}" class="btn btn-dark">+ Add Payment</a>
      </div>

      <form method="GET" action="{{ route('installment.index') }}" class="mb-3">
        <div class="input-group">
          <input
            type="search"
            name="q"
            value="{{ $search ?? '' }}"
            class="form-control"
            placeholder="Search by student or date"
          />
          <button class="btn btn-outline-dark" type="submit">Search</button>
        </div>
      </form>

      <div class="table-responsive">
        <table class="table table-striped table-hover align-middle text-center">
          <thead class="table-dark">
            <tr>
              <th>#</th>
              <th>Student</th>
              <th>Amount Paid</th>
              <th>Paid At</th>
            </tr>
          </thead>
          <tbody>
            @forelse($installments as $installment)
              <tr>
                <td>{{ $installment->id }}</td>
                <td>{{ optional($installment->student)->first_name }} {{ optional($installment->student)->last_name }}</td>
                <td>{{ $installment->amount_paid }}</td>
                <td>{{ $installment->paid_at->toDateString() }}</td>
              </tr>
            @empty
              <tr>
                <td colspan="4" class="text-muted">No payments recorded yet.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
