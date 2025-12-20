<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login | WebInstitute</title>
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
      background: url('{{ asset('assets/images/images.jpeg') }}') center /
        cover no-repeat;
      padding: clamp(24px, 6vw, 96px);
    "
  >
    <main class="container-fluid">
      <div class="row justify-content-end">
        <div class="col-12 col-sm-10 col-md-6 col-lg-4">
          <div
            class="p-4 p-md-5 text-white rounded-4 shadow-lg"
            style="background: rgba(0, 0, 0, 0.45); backdrop-filter: blur(12px)"
          >
            <h1 class="text-center mb-4 fw-semibold">Login</h1>

            <form method="POST" action="{{ route('login') }}" novalidate>
              @csrf
              <div class="mb-4">
                <div class="input-group input-group-lg">
                  <input
                    type="email"
                    name="email"
                    class="form-control bg-transparent text-white border border-light rounded-pill"
                    placeholder="Email"
                    value="{{ old('email') }}"
                    autocomplete="username"
                    required
                  />
                  <span
                    class="input-group-text bg-transparent border border-light rounded-pill text-white"
                  >
                    <i class="bx bxs-user"></i>
                  </span>
                </div>
                @error('email')
                  <small class="text-danger d-block mt-1">{{ $message }}</small>
                @enderror
              </div>

              <div class="mb-4">
                <div class="input-group input-group-lg">
                  <input
                    type="password"
                    name="password"
                    class="form-control bg-transparent text-white border border-light rounded-pill"
                    placeholder="Password"
                    autocomplete="current-password"
                    required
                  />
                  <span
                    class="input-group-text bg-transparent border border-light rounded-pill text-white"
                  >
                    <i class="bx bxs-lock-alt"></i>
                  </span>
                </div>
                @error('password')
                  <small class="text-danger d-block mt-1">{{ $message }}</small>
                @enderror
              </div>

              <div class="d-flex justify-content-between align-items-center mb-4">
                <label class="form-check-label text-white d-flex gap-2 align-items-center">
                  <input
                    class="form-check-input"
                    type="checkbox"
                    name="remember"
                  />
                  Remember me
                </label>
                <a href="{{ route('password.request') }}" class="text-white text-decoration-none">
                  Forgot password?
                </a>
              </div>

              <button
                class="btn btn-light w-100 rounded-pill py-3 fw-semibold"
                type="submit"
              >
                Sign In
              </button>
            </form>

            <p class="text-center mt-4 mb-0">
              Don't have an account?
              <a
                href="{{ route('register') }}"
                class="text-white text-decoration-underline"
                >Sign Up</a
              >
            </p>
          </div>
        </div>
      </div>
    </main>
  </body>
</html>
