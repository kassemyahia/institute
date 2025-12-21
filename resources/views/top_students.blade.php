<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Top Students | WebInstitute</title>
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
              <a class="nav-link active" href="{{ route('top_students.index') }}">Top Students</a>
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
      <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
          <h3 class="mb-1">Top Students</h3>
          <p class="text-muted mb-0">Pick a stage and section to rank students by their average grade.</p>
        </div>
      </div>

      <div class="card shadow-sm mb-3">
        <div class="card-body">
          <form method="GET" action="{{ route('top_students.index') }}">
            <div class="row g-2 align-items-end">
              <div class="col-lg-4">
                <label class="form-label">Stage</label>
                <select name="stage_id" id="stageFilter" class="form-select">
                  <option value="">All stages</option>
                  @foreach ($stages as $stage)
                    <option value="{{ $stage->id }}" @selected(($activeStageId ?? '') == $stage->id)>{{ $stage->name }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-lg-4">
                <label class="form-label">Section</label>
                <select name="section_id" id="sectionFilter" class="form-select" {{ $activeStageId ? '' : 'disabled' }}>
                  <option value="">{{ $activeStageId ? 'All sections' : 'Select a stage first' }}</option>
                  @foreach ($sections as $section)
                    <option value="{{ $section->id }}" @selected(($sectionId ?? '') == $section->id)>{{ $section->name }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-lg-2 d-grid">
                <button class="btn btn-dark" type="submit">Filter</button>
              </div>
            </div>
          </form>
        </div>
      </div>

      <div class="card shadow-sm">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Ranked Students</h5>
            <span class="badge bg-light text-dark">{{ $students->count() }} students</span>
          </div>
          <div class="table-responsive">
            <table class="table table-striped align-middle text-center">
              <thead class="table-dark">
                <tr>
                  <th>#</th>
                  <th>Name</th>
                  <th>Stage</th>
                  <th>Section</th>
                  <th>Average</th>
                  <th>Grades Count</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($students as $index => $student)
                  <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                    <td>{{ $student->stage->name ?? '-' }}</td>
                    <td>{{ $student->section->name ?? '-' }}</td>
                    <td>{{ number_format($student->average_score ?? 0, 2) }}</td>
                    <td>{{ $student->grades_count ?? 0 }}</td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="6" class="text-muted">No students found for the selected filters.</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
      (function () {
        const stageSelect = document.getElementById('stageFilter');
        const sectionSelect = document.getElementById('sectionFilter');
        const sections = @json($sectionOptions);
        const selectedSectionId = '{{ $sectionId ?? '' }}';

        function renderSections(stageId) {
          sectionSelect.innerHTML = '';
          if (!stageId) {
            sectionSelect.disabled = true;
            const placeholder = document.createElement('option');
            placeholder.value = '';
            placeholder.textContent = 'Select a stage first';
            sectionSelect.appendChild(placeholder);
            return;
          }

          sectionSelect.disabled = false;
          const defaultOption = document.createElement('option');
          defaultOption.value = '';
          defaultOption.textContent = 'All sections';
          sectionSelect.appendChild(defaultOption);

          sections
            .filter((section) => String(section.stage_id) === String(stageId))
            .forEach((section) => {
              const opt = document.createElement('option');
              opt.value = section.id;
              opt.textContent = section.name;
              sectionSelect.appendChild(opt);
            });
        }

        renderSections(stageSelect.value);

        if (stageSelect.value && selectedSectionId) {
          Array.from(sectionSelect.options).forEach((opt) => {
            if (opt.value === selectedSectionId) {
              opt.selected = true;
            }
          });
        }

        stageSelect.addEventListener('change', (e) => {
          renderSections(e.target.value);
        });
      })();
    </script>
  </body>
</html>
