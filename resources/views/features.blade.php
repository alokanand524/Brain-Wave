<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Study Tools - BrainWave</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  @vite(['resources/css/style.css'])

  <style>
    body {
      background-color: #f4f7fa;

    }

    .section-title {
      text-align: center;
      margin: 60px 0 30px;
    }

    .tool-section {
      padding: 60px 0;
    }

    .tool-row {
      display: flex;
      align-items: center;
      justify-content: center;
      flex-wrap: wrap;
      margin-bottom: 60px;
    }

    .tool-image {
      flex: 1;
      min-width: 280px;
      text-align: center;
      padding: 20px;
    }

    .tool-image img {
      max-width: 100%;
      height: auto;
    }

    .tool-content {
      flex: 1;
      min-width: 280px;
      padding: 20px;
    }

    .tool-content h3 {
      font-size: 28px;
      font-weight: 600;
      color: #212529;
    }

    .tool-content p {
      font-size: 16px;
      color: #555;
    }

    .alt-row .tool-image {
      order: 2;
    }

    .alt-row .tool-content {
      order: 1;
    }

    @media (max-width: 768px) {

      .tool-row,
      .alt-row {
        flex-direction: column;
      }

      .tool-image,
      .tool-content {
        order: unset !important;
      }
    }
  </style>
</head>

<body>

  <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container">
      <a class="navbar-brand" href="#">BrainWave</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">  
          <li class="nav-item">
            <a class="nav-link active" href="{{  route('index') }}">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{  route('features') }}">Features</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="">Explore</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#contact">Contact</a>
          </li>
        </ul>

        <button id="theme-toggle" class="btn btn-outline-light ms-3" title="Toggle Dark/Light Theme">
          <i class="fas fa-moon" id="theme-icon"></i>
        </button>
        <a href="{{ route('studyRoom') }}" class="btn btn-join ms-3">Join Now</a>
      </div>
    </div>
  </nav>


  <section class="container">
    <div class="section-title">
      <h2>Study Smarter with These Tools</h2>
      <p>Find the right study group that fits your needs.</p>
    </div>

    <!-- Tool 1: Live Sessions -->
    <div class="tool-row">
      <div class="tool-image">
        <img src="{{ asset('image/live-session.svg') }}" alt="Live Sessions">
      </div>
      <div class="tool-content">
        <h3>Live Sessions</h3>
        <p>Join real-time, interactive study sessions where you can collaborate with peers, discuss problems, and stay motivated with live presence.</p>
      </div>
    </div>

    <!-- Tool 2: Shared Resources -->
    <div class="tool-row alt-row">
      <div class="tool-image">
        <img src="{{ asset('image/shared-resources.svg') }}" alt="Shared Resources">
      </div>
      <div class="tool-content">
        <h3>Shared Resources</h3>
        <p>Access a curated collection of notes, slides, and reference materials shared by other learners, all in one place.</p>
      </div>
    </div>

    <!-- Tool 3: Collaborative Quizzes -->
    <div class="tool-row">
      <div class="tool-image">
        <img src="{{ asset('image/collaborative-quiz.svg') }}" alt="Collaborative Quizzes">
      </div>
      <div class="tool-content">
        <h3>Collaborative Quizzes</h3>
        <p>Challenge yourself and others with group quizzes that reinforce your learning and promote friendly competition.</p>
      </div>
    </div>
  </section>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    const toggleBtn = document.getElementById("theme-toggle");
    const icon = document.getElementById("theme-icon");

    // Load saved mode
    if (localStorage.getItem("theme") === "dark") {
      document.body.classList.add("dark-mode");
      icon.classList.replace("fa-moon", "fa-sun");
    }

    toggleBtn.addEventListener("click", () => {
      document.body.classList.toggle("dark-mode");
      const isDark = document.body.classList.contains("dark-mode");

      if (isDark) {
        icon.classList.replace("fa-moon", "fa-sun");
        localStorage.setItem("theme", "dark");
      } else {
        icon.classList.replace("fa-sun", "fa-moon");
        localStorage.setItem("theme", "light");
      }
    });
  </script>
</body>

</html>