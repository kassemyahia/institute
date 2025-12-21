<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Class Rooms | WebInstitute</title>
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
      <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3">
        <div>
          <h3 class="mb-1">Class Rooms</h3>
          <p class="text-muted mb-0">Pick a stage, then a section to see its students.</p>
        </div>
        <div class="d-flex gap-2">
          <button class="btn btn-outline-dark btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#newClassForm" aria-expanded="false" aria-controls="newClassForm">
            Open New Class
          </button>
          <a href="{{ route('student.create') }}" class="btn btn-dark btn-sm">Add Student</a>
        </div>
      </div>

      @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          {{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif

      <div class="collapse mb-4" id="newClassForm">
        <div class="card card-body shadow-sm">
          <div class="row g-4">
            <div class="col-md-6">
              <h6 class="fw-bold">Create Stage</h6>
              <form method="POST" action="{{ route('stage.store') }}">
                @csrf
                <div class="mb-3">
                  <label class="form-label">Stage Name</label>
                  <input type="text" name="name" class="form-control" required />
                </div>
                <button class="btn btn-dark btn-sm" type="submit">Save Stage</button>
              </form>
            </div>
            <div class="col-md-6">
              <h6 class="fw-bold">Create Section in Stage</h6>
              <form method="POST" action="{{ route('section.store') }}">
                @csrf
                <div class="mb-3">
                  <label class="form-label">Stage</label>
                  <select name="stage_id" class="form-select" required>
                    <option value="">Select stage</option>
                    @foreach ($stages as $stage)
                      <option value="{{ $stage->id }}">{{ $stage->name }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="mb-3">
                  <label class="form-label">Section Name</label>
                  <input type="text" name="name" class="form-control" required />
                </div>
                <button class="btn btn-dark btn-sm" type="submit">Save Section</button>
              </form>
            </div>
          </div>
        </div>
      </div>

      <div class="card shadow-sm">
        <div class="card-body">
          <div class="mb-3">
            <div class="d-flex flex-wrap gap-2" id="stageTabs">
              @forelse ($stages as $stage)
                <button
                  type="button"
                  class="btn btn-outline-dark btn-sm stage-btn {{ ($defaultStageId ?? null) === $stage->id ? 'active' : '' }}"
                  data-stage="{{ $stage->id }}"
                >
                  {{ $stage->name }}
                </button>
              @empty
                <span class="text-muted">No stages available.</span>
              @endforelse
            </div>
          </div>

          <div class="mb-4">
            <div class="d-flex align-items-center">
              <button class="btn btn-outline-secondary btn-sm me-2" type="button" id="sectionPrev">&lsaquo;</button>
              <div class="flex-grow-1 position-relative">
                <div
                  id="sectionTrack"
                  class="d-flex gap-2 flex-nowrap"
                  style="overflow-x: auto; scroll-behavior: smooth;"
                ></div>
              </div>
              <button class="btn btn-outline-secondary btn-sm ms-2" type="button" id="sectionNext">&rsaquo;</button>
            </div>
          </div>

          <div id="studentList" class="row g-3"></div>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
      (function () {
        const stageTabs = document.getElementById('stageTabs');
        const sectionTrack = document.getElementById('sectionTrack');
        const studentList = document.getElementById('studentList');
        const sectionPrev = document.getElementById('sectionPrev');
        const sectionNext = document.getElementById('sectionNext');

        const classroomData = @json($classroomData ?? []);
        let activeStageId = '{{ $defaultStageId ?? '' }}';
        let activeSectionId = '{{ $defaultSectionId ?? '' }}';

        function findStage(stageId) {
          return classroomData.find((stage) => String(stage.id) === String(stageId));
        }

        function renderStages() {
          if (!stageTabs) return;

          Array.from(stageTabs.querySelectorAll('.stage-btn')).forEach((btn) => {
            btn.classList.toggle('active', String(btn.dataset.stage) === String(activeStageId));
          });
        }

        function renderSections(stageId) {
          sectionTrack.innerHTML = '';
          const stage = findStage(stageId);

          if (!stage || !stage.sections.length) {
            sectionTrack.innerHTML = '<span class="text-muted">No sections for this stage.</span>';
            activeSectionId = '';
            renderStudents();
            return;
          }

          if (!stage.sections.some((section) => String(section.id) === String(activeSectionId))) {
            activeSectionId = stage.sections[0]?.id ?? '';
          }

          stage.sections.forEach((section) => {
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'btn btn-outline-primary btn-sm section-btn';
            btn.dataset.section = section.id;
            btn.textContent = section.name;
            if (String(section.id) === String(activeSectionId)) {
              btn.classList.add('active');
            }
            btn.addEventListener('click', () => {
              activeSectionId = section.id;
              renderSections(activeStageId);
              renderStudents();
            });
            sectionTrack.appendChild(btn);
          });
        }

        function renderStudents() {
          studentList.innerHTML = '';
          const stage = findStage(activeStageId);
          const section = stage?.sections.find((s) => String(s.id) === String(activeSectionId));

          if (!section || !section.students.length) {
            studentList.innerHTML = '<div class="col-12 text-muted">No students in this section.</div>';
            return;
          }

          section.students.forEach((student) => {
            const col = document.createElement('div');
            col.className = 'col-md-4';
            col.innerHTML = `
              <div class="border rounded p-3 h-100 shadow-sm">
                <div class="d-flex justify-content-between align-items-start mb-2">
                  <strong>${student.first_name} ${student.last_name}</strong>
                  <span class="badge bg-light text-dark">${student.gender ?? ''}</span>
                </div>
                <a class="btn btn-sm btn-outline-primary" href="{{ url('student') }}/${student.id}">View student</a>
              </div>
            `;
            studentList.appendChild(col);
          });
        }

        function setupStageClicks() {
          Array.from(stageTabs.querySelectorAll('.stage-btn')).forEach((btn) => {
            btn.addEventListener('click', () => {
              activeStageId = btn.dataset.stage;
              renderStages();
              renderSections(activeStageId);
              renderStudents();
            });
          });
        }

        function setupSectionNav() {
          const scrollAmount = 200;
          sectionPrev.addEventListener('click', () => {
            sectionTrack.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
          });
          sectionNext.addEventListener('click', () => {
            sectionTrack.scrollBy({ left: scrollAmount, behavior: 'smooth' });
          });
        }

        setupStageClicks();
        setupSectionNav();
        renderStages();
        renderSections(activeStageId);
        renderStudents();
      })();
    </script>
  </body>
</html>
