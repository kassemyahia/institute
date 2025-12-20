<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Welcome</title>

    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link
      href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
      rel="stylesheet"
    />
  </head>

  <body
    class="d-flex align-items-center justify-content-end min-vh-100"
    style="
      background: url('{{ asset('assets/images/images.jpeg') }}') center / cover
        no-repeat;
      padding: clamp(24px, 6vw, 96px);
    "
  >
    <main class="container-fluid">
      <div class="row justify-content-end">
        <div class="col-12 col-sm-10 col-md-6 col-lg-4">
          <div
            class="p-4 p-md-5 text-white rounded-4 shadow-lg text-center"
            style="background: rgba(0, 0, 0, 0.45); backdrop-filter: blur(12px)"
          >
            <div class="mb-4">
              <i class="bx bxs-rocket bx-lg"></i>
            </div>
            <h1 class="fw-semibold mb-3">Welcome to WebInstitute</h1>
            <p class="mb-4 text-white-50">
              Seamlessly manage your learning experience. Log in if you already
              have an account or create a new one to get started.
            </p>

            <div class="d-grid gap-3">
              <a
                href="{{ route('login') }}"
                class="btn btn-light rounded-pill py-2 fw-semibold shadow"
              >
                Login
              </a>
              <a
                href="{{ route('register') }}"
                class="btn btn-outline-light rounded-pill py-2 fw-semibold"
              >
                Sign up
              </a>
            </div>
          </div>
        </div>
      </div>
    </main>
  </body>
</html>
