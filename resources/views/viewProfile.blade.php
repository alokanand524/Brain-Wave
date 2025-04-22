<!-- Profile Page -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profile Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: rgb(255, 255, 255);
        }

        .profile-card {
            background: #fff;
            border-radius: 10% 10% 10% 10%;
            padding: 2rem;
            box-shadow: 0 4px 16px rgb(101, 99, 98);
            width: 45%;
        }

        .profile-img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #198754;
        }

        .nav-tabs .nav-link.active {
            background-color: #198754;
            color: white;
        }

        @media (max-width: 576px) {
            .profile-img {
                width: 90px;
                height: 90px;
            }
        }

        .position-relative .edit-icon {
            position: absolute;
            bottom: 8px;
            right: 8px;
            background-color: #198754;
            border-radius: 50%;
            padding: 6px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.3s;
        }

        .position-relative .edit-icon:hover {
            background-color: #157347;
        }

        .cursor-pointer {
            cursor: pointer;
        }


        /* zoom  image css */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            padding-top: 50px;
            left: 0;
            top: 0;
            width: max-content;
            height: max-content;
            background-color: rgba(0, 0, 0, 0.8);
            overflow: auto;
        }

        .modal-content {
            margin: auto;
            display: block;
            max-width: 80%;
            border-radius: 10px;
            animation: zoom 0.3s ease-in-out;
        }

        @keyframes zoom {
            from {
                transform: scale(0.7);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        .close {
            position: absolute;
            top: 30px;
            right: 50px;
            color: white;
            font-size: 40px;
            font-weight: bold;
            cursor: pointer;
        }
    </style>
</head>

<body>

    <div class="container py-5 d-flex flex-wrap justify-content-around">

        <div class="profile-card text-center mb-4">
            <!-- <form method="POST" action="{{ route('profile.update.image') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @auth
                <img src="{{ Auth::user()->profile_image ?? 'https://i.pravatar.cc/150?img=8' }}" alt="Profile" class="profile-img mb-3">
                <div class="mb-2">
                    <input type="file" name="profile_image" class="form-control">
                </div>
            @endauth
            <button class="btn btn-outline-success" type="submit">Reupload Image</button>
        </form> -->


            <!-- Profile Image Upload (Click to Edit) -->
            @auth
            <form method="POST" action="{{ route('profile.update.image') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="position-relative d-inline-block">
                    <input type="file" id="profileImageInput" name="profile_image" class="d-none" onchange="this.form.submit()">
                    <img src="{{ Auth::user()->profile_image ?? 'https://i.pravatar.cc/150?img=8' }}"
                        alt="{{ Auth::user()->name }}"
                        class="profile-img mb-3 cursor-pointer"
                        id="profileImage">

                    <span class="edit-icon" id="profileImagePreview"
                        onclick="document.getElementById('profileImageInput').click()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#fff" class="bi bi-pencil-square" viewBox="0 0 16 16">
                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706l-1 1a.5.5 0 0 1-.707 0l-1-1a.5.5 0 1 1 .707-.707l.647.646.647-.646a.5.5 0 0 1 .706 0z" />
                            <path d="M13.5 3.207l-1-1L4 10.707V12h1.293l8.207-8.793z" />
                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                        </svg>
                    </span>
                </div>
            </form>
            @endauth


            <h4 class="mt-3">
                @auth
                {{ Auth::user()->name }}
                @endauth
            </h4>
            <p class="text-muted">Web Developer</p>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editModal">Edit Profile</button>
        </div>

        <!-- ##################################################################### -->
        <!-- Popup Modal to show image in zoom-->
        <div id="imageModal" class="modal">
            <span class="close">&times;</span>
            diimg class="modal-content" id="popupImage">
        </div>
        <!-- ##################################################################### -->


        <div class="tab-content p-3 bg-white rounded-bottom profile-card" id="profileTabContent">
            <ul class="nav nav-tabs justify-content-center" id="profileTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info" type="button" role="tab">Info</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="activity-tab" data-bs-toggle="tab" data-bs-target="#activity" type="button" role="tab">Activity</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="settings-tab" data-bs-toggle="tab" data-bs-target="#settings" type="button" role="tab">Settings</button>
                </li>
            </ul>

            <div class="tab-pane fade show active" id="info" role="tabpanel" style="margin-top: 1rem;">
                @auth
                <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                <p><strong>Mobile:</strong> {{ Auth::user()->mobile ?? 'Not set' }}</p>
                <p><strong>DOB:</strong> {{ Auth::user()->date_of_birth ?? 'Not set' }}</p>
                <p><strong>Gender:</strong> {{ Auth::user()->gender ?? 'Not set' }}</p>
                @endauth
            </div>

            <div class="tab-pane fade" id="activity" role="tabpanel">
                <p>No recent activity yet.</p>
            </div>

            <div class="tab-pane fade" id="settings" role="tabpanel">
                <p>Notification Settings, Theme, etc.</p>
            </div>
        </div>

    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="editProfileForm" method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title">Edit Profile</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-2">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="name" class="form-control" value="{{ Auth::user()->name }}">
                        </div>

                        <div class="mb-2">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ Auth::user()->email }}" readonly>
                        </div>

                        <div class="mb-2">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control" value="{{ Auth::user()->mobile }}">
                        </div>

                        <div class="mb-2">
                            <label class="form-label">DOB</label>
                            <input type="date" name="dob" class="form-control" value="{{ Auth::user()->date_of_birth }}">
                        </div>

                        <div class="mb-2">
                            <label class="form-label">Gender</label>
                            <select name="gender" class="form-select">
                                <option value="Male" {{ Auth::user()->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ Auth::user()->gender == 'Female' ? 'selected' : '' }}>Female</option>
                                <option value="Other" {{ Auth::user()->gender == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-success w-100">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Get elements
        const modal = document.getElementById("imageModal");
        const img = document.getElementById("profileImage");
        const modalImg = document.getElementById("popupImage");
        const closeBtn = document.getElementsByClassName("close")[0];

        // On click, show modal
        img.onclick = function() {
            modal.style.display = "block";
            modalImg.src = this.src;
        }

        // Close modal
        closeBtn.onclick = function() {
            modal.style.display = "none";
        }
    </script>
</body>

</html>