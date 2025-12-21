<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Register Grade | WebInstitute</title>
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
            <li class="nav-item"><a class="nav-link" href="{{ route('student_grade.index') }}">Grades</a></li>
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
              <h4 class="card-title text-center mb-4">Register Grade</h4>

              <form method="POST" action="{{ route('student_grade.store') }}">
                @csrf
                <div class="mb-3">
                  <label class="form-label">Student</label>
                  <select name="student_id" class="form-select" required>
                    <option value="">Select student</option>
                    @foreach ($students as $student)
                      <option value="{{ $student->id }}" @selected(old('student_id', $selectedStudent ?? '') == $student->id)>
                        {{ $student->first_name }} {{ $student->last_name }}
                      </option>
                    @endforeach
                  </select>
                </div>

                <div class="mb-3">
                  <label class="form-label">Subject</label>
                  <select name="subject_id" class="form-select" required>
                    <option value="">Select subject</option>
                    @foreach ($subjects as $subject)
                      <option value="{{ $subject->id }}" @selected(old('subject_id', $selectedSubject ?? '') == $subject->id)>
                        {{ $subject->name }}
                      </option>
                    @endforeach
                  </select>
                </div>

                <div class="mb-3">
                  <label class="form-label">Score</label>
                  <input type="number" step="0.01" min="0" max="100" name="score" class="form-control" value="{{ old('score') }}" />
                </div>

                <div class="text-center">
                  <button class="btn btn-dark px-4" type="submit">Save Grade</button>
                  <a href="{{ route('student_grade.index') }}" class="btn btn-secondary px-4">Cancel</a>
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
