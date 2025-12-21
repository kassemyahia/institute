<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>WebInstitute</title>
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
              <a class="nav-link active" href="{{ route('home') }}">Home</a>
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
              <a class="nav-link" href="#">About</a>
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
      <div class="text-center mb-5">
        <img
          src="{{ asset('assets/images/logo-dark.png') }}"
          height="120"
          class="mb-3"
          alt="WebInstitute"
        />
        <h1 class="fw-bold">Welcome to WebInstitute</h1>
        <p class="text-muted">
          Your gateway to quality education and management
        </p>
        </div>

      <div class="row g-4">
        <div class="col-lg-3 col-md-6">
          <div class="card shadow-sm h-100">
            <div class="card-body">
              <h5 class="card-title">Employees</h5>
              <p class="card-text">Teachers, Managers…</p>
              <a
                href="{{ route('employee.create') }}"
                class="btn btn-dark btn-sm"
                >Add Employee</a
              >
              <a
                href="{{ route('employee.index') }}"
                class="btn btn-outline-dark btn-sm"
                >View</a
              >
            </div>
          </div>
        </div>

        <div class="col-lg-3 col-md-6">
          <div class="card shadow-sm h-100">
            <div class="card-body">
              <h5 class="card-title">Students</h5>
              <p class="card-text">Add / Delete Students</p>
              <a
                href="{{ route('student.create') }}"
                class="btn btn-dark btn-sm"
                >Add Student</a
              >
              <a
                href="{{ route('student.index') }}"
                class="btn btn-outline-dark btn-sm"
                >View</a
              >
            </div>
          </div>
        </div>

        <div class="col-lg-3 col-md-6">
          <div class="card shadow-sm h-100">
            <div class="card-body d-flex flex-column">
              <h5 class="card-title">Payments</h5>
              <p class="card-text">Manage payments</p>
              <div class="mt-auto d-flex gap-2 flex-wrap">
                <a href="{{ route('installment.create') }}" class="btn btn-dark btn-sm">Add Payment</a>
                <a href="{{ route('installment.index') }}" class="btn btn-outline-dark btn-sm">View</a>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-3 col-md-6">
          <div class="card shadow-sm h-100">
            <div class="card-body d-flex flex-column">
              <h5 class="card-title">Class Rooms</h5>
              <p class="card-text">Browse stages and sections.</p>
              <div class="mt-auto">
                <a href="{{ route('classrooms.index') }}" class="btn btn-dark btn-sm">Open</a>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-3 col-md-6">
          <div class="card shadow-sm h-100">
            <div class="card-body d-flex flex-column">
              <h5 class="card-title">Subjects</h5>
              <p class="card-text">View and create subjects.</p>
              <div class="mt-auto">
                <a href="{{ route('subject.index') }}" class="btn btn-dark btn-sm">Open</a>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-3 col-md-6">
          <div class="card shadow-sm h-100">
            <div class="card-body d-flex flex-column">
              <h5 class="card-title">Top Students</h5>
              <p class="card-text">Rank students by average grade.</p>
              <div class="mt-auto">
                <a href="{{ route('top_students.index') }}" class="btn btn-dark btn-sm">Open</a>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-3 col-md-6">
          <div class="card shadow-sm h-100">
            <div class="card-body d-flex flex-column">
              <h5 class="card-title">Grades</h5>
              <p class="card-text">Register or review student grades.</p>
              <div class="mt-auto">
                <a href="{{ route('student_grade.index') }}" class="btn btn-dark btn-sm">Open</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
