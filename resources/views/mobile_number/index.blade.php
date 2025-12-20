<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Phone Numbers | WebInstitute</title>
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
            <li class="nav-item"><a class="nav-link active" href="{{ route('mobile_number.index') }}">Phone Numbers</a></li>
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
        <h3>Phone Numbers</h3>
        <a href="{{ route('mobile_number.create') }}" class="btn btn-dark">+ Add Number</a>
      </div>

      <div class="table-responsive">
        <table class="table table-striped table-hover align-middle text-center">
          <thead class="table-dark">
            <tr>
              <th>#</th>
              <th>Owner</th>
              <th>Type</th>
              <th>Phone</th>
            </tr>
          </thead>
          <tbody>
            @forelse($mobileNumbers as $number)
              <tr>
                <td>{{ $number->id }}</td>
                <td>
                  @if($number->owner)
                    {{ $number->owner->first_name ?? '' }} {{ $number->owner->last_name ?? '' }}
                  @else
                    <span class="text-muted">N/A</span>
                  @endif
                </td>
                <td>{{ class_basename($number->owner_type) }}</td>
                <td>{{ $number->phone_number }}</td>
              </tr>
            @empty
              <tr>
                <td colspan="4" class="text-muted">No phone numbers yet.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
