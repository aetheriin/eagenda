<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Login | E-Agenda</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <!-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> -->

  <style>
    body { background: #f4f6f9; }
    .login-card { max-width: 420px; margin: 60px auto; }
    .navbar-custom {
      background-color: #122f4eff;
      color: white;
    }
    .navbar-brand img {
      height: 30px;
      margin-right: 10px;
    }

    
  </style>
</head>
<body class="hold-transition">

  <!-- Navbar -->
  <nav class="navbar navbar-expand navbar-custom">
    <div class="container">
      <a href="#" class="navbar-brand d-flex align-items-center text-white">
        <img src="{{ asset('images/logo.png') }}" alt="Logo">
        <strong>E-Agenda BPS Dumai</strong>
      </a>
    </div>
  </nav>

  <!-- Login Card -->
  <div class="login-card card shadow-sm">
    <div class="card-body login-card-body">

      <!-- Judul Masuk -->
      <h4 class="text-center mb-4 font-weight-bold">Masuk</h4>

      <!-- Tampilkan Error -->
      @if($errors->any())
        <div class="alert alert-danger">
          <ul class="mb-0">
            @foreach($errors->all() as $e)
              <li>{{ $e }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <!-- Form -->
      <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="input-group mb-3">
          <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="Email" required autofocus>
          <div class="input-group-append">
            <div class="input-group-text"><i class="fas fa-envelope"></i></div>
          </div>
        </div>

        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="Password" required>
          <div class="input-group-append">
            <div class="input-group-text"><i class="fas fa-lock"></i></div>
          </div>
        </div>

        <div class="input-group mb-3">
          <select name="tahun" class="form-control" required>
            @php $current = now()->year; @endphp
            @for($y = $current; $y >= $current - 5; $y--)
              <option value="{{ $y }}" {{ old('tahun') == $y ? 'selected' : '' }}>{{ $y }}</option>
            @endfor
          </select>
          <div class="input-group-append">
            <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
          </div>
        </div>

        <div class="row mb-2">
          <div class="col-8">
            <div class="form-check">
              <input type="checkbox" name="remember" id="remember" class="form-check-input" {{ old('remember') ? 'checked' : '' }}>
              <label for="remember" class="form-check-label">Ingat saya</label>
            </div>
          </div>
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Masuk</button>
          </div>
        </div>

        @if (Route::has('password.request'))
          <p class="mb-1">
            <a href="{{ route('password.request') }}">Lupa password?</a>
          </p>
        @endif
      </form>
    </div>

    <div class="card-footer text-center">
      <small>© {{ date('Y') }} BPS Kota Dumai</small>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>
</body>
</html>
