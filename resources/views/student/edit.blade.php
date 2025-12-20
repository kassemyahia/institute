<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Edit Student | Sho</title>
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
        <div class="col-lg-6">
          <div class="card shadow-sm">
            <div class="card-body">
              <h4 class="card-title text-center mb-4">Edit Student</h4>

              <form method="POST" action="{{ route('student.update', $student) }}">
                @csrf
                @method('PUT')
                <div class="mb-3">
                  <label class="form-label">First Name</label>
                  <input type="text" name="first_name" class="form-control" value="{{ old('first_name', $student->first_name) }}" required />
                </div>

                <div class="mb-3">
                  <label class="form-label">Last Name</label>
                  <input type="text" name="last_name" class="form-control" value="{{ old('last_name', $student->last_name) }}" required />
                </div>

                <div class="mb-3">
                  <label class="form-label">Gender</label>
                  <select class="form-select" name="gender">
                    <option value="">Select gender</option>
                    <option value="male" @selected(old('gender', $student->gender) === 'male')>Male</option>
                    <option value="female" @selected(old('gender', $student->gender) === 'female')>Female</option>
                  </select>
                </div>

                <div class="mb-3">
                  <label class="form-label">Birth Date</label>
                  <input type="date" name="birth_date" class="form-control" value="{{ old('birth_date', optional($student->birth_date)->toDateString()) }}" />
                </div>

                <div class="mb-3">
                  <label class="form-label">Registration Date</label>
                  <input type="date" name="registration_date" class="form-control" value="{{ old('registration_date', optional($student->registration_date)->toDateString()) }}" />
                </div>

                <div class="mb-3">
                  <label class="form-label">Stage</label>
                  <select name="stage_id" id="stageSelect" class="form-select">
                    <option value="">Select stage</option>
                    @foreach($stages as $stage)
                      <option value="{{ $stage->id }}" @selected(old('stage_id', $student->stage_id) == $stage->id)>{{ $stage->name }}</option>
                    @endforeach
                  </select>
                </div>

                <div class="mb-3">
                  <label class="form-label">Section</label>
                  <select name="section_id" id="sectionSelect" class="form-select" required>
                    <option value="">Select section</option>
                    @foreach($sections as $section)
                      <option value="{{ $section->id }}" data-stage="{{ $section->stage_id }}" @selected(old('section_id', $student->section_id) == $section->id)>{{ $section->name }}</option>
                    @endforeach
                  </select>
                </div>

                <div class="mb-3">
                  <label class="form-label">Full Price</label>
                  <input type="number" min="0" step="0.01" name="full_price" class="form-control" value="{{ old('full_price', $student->full_price) }}" />
                </div>

                <div class="form-check mb-3">
                  <input class="form-check-input" type="checkbox" value="1" id="is_fully_paid" name="is_fully_paid" @checked(old('is_fully_paid', $student->is_fully_paid)) />
                  <label class="form-check-label" for="is_fully_paid">
                    Fully Paid
                  </label>
                </div>

                <div class="text-center">
                  <button class="btn btn-dark px-4" type="submit">Save</button>
                  <a href="{{ route('student.show', $student) }}" class="btn btn-danger px-4">Cancel</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    (function () {
      const stageSelect = document.getElementById('stageSelect');
      const sectionSelect = document.getElementById('sectionSelect');
      const sections = Array.from(sectionSelect.options)
        .filter(opt => opt.value !== '')
        .map(opt => ({
          id: opt.value,
          name: opt.textContent,
          stageId: opt.dataset.stage || '',
        }));

      function renderSections(stageId) {
        sectionSelect.innerHTML = '<option value=\"\">Select section</option>';
        const filtered = stageId ? sections.filter(s => s.stageId === stageId) : sections;
        filtered.forEach(sec => {
          const opt = document.createElement('option');
          opt.value = sec.id;
          opt.textContent = sec.name;
          opt.dataset.stage = sec.stageId;
          sectionSelect.appendChild(opt);
        });
      }

      renderSections(stageSelect.value);
      const oldSection = '{{ old('section_id', $student->section_id) }}';
      if (oldSection) {
        Array.from(sectionSelect.options).forEach(opt => {
          if (opt.value === oldSection) opt.selected = true;
        });
      }

      stageSelect.addEventListener('change', (e) => {
        renderSections(e.target.value);
      });
    })();
  </script>
</body>
</html>
