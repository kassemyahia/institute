<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Grades | WebInstitute</title>
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
            <li class="nav-item"><a class="nav-link active" href="{{ route('student_grade.index') }}">Grades</a></li>
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
        <h3 class="mb-0">Grades</h3>
        <a href="{{ route('student_grade.create') }}" class="btn btn-dark btn-sm">Register Grade</a>
      </div>

      <div class="card shadow-sm mb-3">
        <div class="card-body">
          <form method="GET" action="{{ route('student_grade.index') }}">
            <div class="row g-2 align-items-end">
              <div class="col-lg-4">
                <label class="form-label">Stage</label>
                <select name="stage_id" id="stageFilter" class="form-select">
                  <option value="">All stages</option>
                  @foreach ($stages as $stage)
                    <option value="{{ $stage->id }}" @selected(($stageId ?? '') == $stage->id)>{{ $stage->name }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-lg-4">
                <label class="form-label">Section</label>
                <select name="section_id" id="sectionFilter" class="form-select" {{ ($stageId ?? '') ? '' : 'disabled' }}>
                  <option value="">{{ ($stageId ?? '') ? 'All sections' : 'Select a stage first' }}</option>
                  @foreach ($sections as $section)
                    <option value="{{ $section->id }}" @selected(($sectionId ?? '') == $section->id)>{{ $section->name }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-lg-3">
                <label class="form-label">Subject</label>
                <select name="subject_id" id="subjectFilter" class="form-select" {{ ($sectionId ?? '') ? '' : 'disabled' }}>
                  <option value="">{{ ($sectionId ?? '') ? 'All subjects' : 'Select a section first' }}</option>
                </select>
              </div>
              <div class="col-lg-1 d-grid">
                <button class="btn btn-dark" type="submit">Filter</button>
              </div>
            </div>
          </form>
        </div>
      </div>

      @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          {{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif

      <div class="card shadow-sm">
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-striped align-middle text-center">
              <thead class="table-dark">
                <tr>
                  <th>ID</th>
                  <th>Student</th>
                  <th>Stage</th>
                  <th>Section</th>
                  <th>Subject</th>
                  <th>Score</th>
                  <th>Updated</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($grades as $grade)
                  <tr>
                    <td>{{ $grade->id }}</td>
                    <td>{{ $grade->student->first_name ?? '' }} {{ $grade->student->last_name ?? '' }}</td>
                    <td>{{ $grade->student->stage->name ?? '-' }}</td>
                    <td>{{ $grade->student->section->name ?? '-' }}</td>
                    <td>{{ $grade->subject->name ?? '' }}</td>
                    <td>{{ $grade->score ?? '—' }}</td>
                    <td>
                      <div class="d-flex justify-content-center align-items-center gap-2">
                        <span>{{ optional($grade->updated_at)->format('Y-m-d') }}</span>
                        <a
                          class="btn btn-sm btn-outline-primary"
                          href="{{ route('student_grade.create', ['student_id' => $grade->student_id, 'subject_id' => $grade->subject_id]) }}"
                        >
                          Register Grade
                        </a>
                      </div>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="7" class="text-muted">No grades recorded.</td>
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
        const subjects = @json($subjectOptions);
        const subjectSelect = document.getElementById('subjectFilter');
        const selectedSubjectId = '{{ $subjectId ?? '' }}';
        const selectedSectionId = '{{ $sectionId ?? '' }}';

        function renderSections(stageId) {
          sectionSelect.innerHTML = '';
          if (!stageId) {
            sectionSelect.disabled = true;
            const placeholder = document.createElement('option');
            placeholder.value = '';
            placeholder.textContent = 'Select a stage first';
            sectionSelect.appendChild(placeholder);
            renderSubjects(null);
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

          renderSubjects(sectionSelect.value);
        }

        function renderSubjects(sectionId) {
          subjectSelect.innerHTML = '';
          if (!sectionId) {
            subjectSelect.disabled = true;
            const placeholder = document.createElement('option');
            placeholder.value = '';
            placeholder.textContent = 'Select a section first';
            subjectSelect.appendChild(placeholder);
            return;
          }

          subjectSelect.disabled = false;
          const defaultOption = document.createElement('option');
          defaultOption.value = '';
          defaultOption.textContent = 'All subjects';
          subjectSelect.appendChild(defaultOption);

          subjects
            .filter((subject) => String(subject.section_id) === String(sectionId))
            .forEach((subject) => {
              const opt = document.createElement('option');
              opt.value = subject.id;
              opt.textContent = subject.name;
              subjectSelect.appendChild(opt);
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

        if (sectionSelect.value && selectedSubjectId) {
          Array.from(subjectSelect.options).forEach((opt) => {
            if (opt.value === selectedSubjectId) {
              opt.selected = true;
            }
          });
        }

        stageSelect.addEventListener('change', (e) => {
          renderSections(e.target.value);
        });

        sectionSelect.addEventListener('change', (e) => {
          renderSubjects(e.target.value);
        });
      })();
    </script>
  </body>
</html>
