{{-- resources/views/auth-modal.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login/Register Popup</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet" />
  <style>
    /* Include glass-card and related styles here */
    /* paste the same CSS from earlier */
  </style>
</head>
<body>

  <div class="container text-center mt-5">
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#authModal">Login</button>
    <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#authModal">Register</button>
  </div>

  {{-- MODAL --}}
  @include('components.auth-popup') {{-- separate modal component file (optional) --}}

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://accounts.google.com/gsi/client" async defer></script>
  <script>
    // JS for switchForm, Google Sign-In, and form handling
  </script>
</body>
</html>
