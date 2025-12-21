<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Subjects | WebInstitute</title>
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
            alt="WebInstitute"
          />
        </a>
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#mainNav"
        >
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNav">
          <ul class="navbar-nav ms-auto gap-2 align-items-center">
            <li class="nav-item">
              <a class="nav-link" href="{{ route('home') }}">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('employee.index') }}"
                >Employees</a
              >
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('student.index') }}"
                >Students</a
              >
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('installment.index') }}">Payments</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" href="{{ route('subject.index') }}">Subjects</a>
            </li>
            <li class="nav-item">
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn btn-outline-light btn-sm" type="submit">
                  Logout
                </button>
              </form>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="container mt-5 pt-4">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
          <h3 class="mb-1">Subjects</h3>
          <p class="text-muted mb-0">View and add subjects per section.</p>
        </div>
      </div>

      @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          {{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif

      <div class="row g-4">
        <div class="col-lg-7">
          <div class="card shadow-sm h-100">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">All Subjects</h5>
                <span class="badge bg-light text-dark">{{ $subjects->count() }} total</span>
              </div>
              <div class="table-responsive">
                <table class="table table-sm align-middle">
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>Stage</th>
                      <th>Section</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse ($subjects as $subject)
                      <tr>
                        <td>{{ $subject->name }}</td>
                        <td>{{ $subject->section->stage->name ?? '-' }}</td>
                        <td>{{ $subject->section->name ?? '-' }}</td>
                        <td class="text-end">
                          <form action="{{ route('subject.destroy', $subject) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this subject?')">Delete</button>
                          </form>
                        </td>
                      </tr>
                    @empty
                      <tr>
                        <td colspan="3" class="text-muted text-center">No subjects available.</td>
                      </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-5">
          <div class="card shadow-sm h-100">
            <div class="card-body">
              <h5 class="card-title mb-3">Add Subject</h5>
              <form method="POST" action="{{ route('subject.store') }}">
                @csrf
                <div class="mb-3">
                  <label class="form-label">Subject Name</label>
                  <input type="text" name="name" class="form-control" value="{{ old('name') }}" required />
                </div>
                <div class="mb-3">
                  <label class="form-label">Section</label>
                  <select name="section_id" class="form-select" required>
                    <option value="">Select section</option>
                    @foreach ($sections as $section)
                      <option value="{{ $section->id }}" @selected(old('section_id') == $section->id)>
                        {{ $section->stage->name ?? 'Stage' }} — {{ $section->name }}
                      </option>
                    @endforeach
                  </select>
                </div>
                <button class="btn btn-dark btn-sm" type="submit">Save Subject</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
