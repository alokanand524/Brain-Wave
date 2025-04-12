<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>user Dashboard | Brain Wave</title>
</head>

<body>

    <!-- resources/views/dashboard.blade.php -->

    @extends('layouts.app')

    @section('content')
    <div class="container">
        <h2 class="mb-4">Welcome, {{ $user->name ?? 'User' }}</h2>

        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('update.details') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Name -->
            <div class="mb-3">
                <label>Name:</label>
                @if($user->name)
                <p>{{ $user->name }}</p>
                @else
                <input type="text" name="name" class="form-control">
                @endif
            </div>

            <!-- Email (always shown but never editable) -->
            <div class="mb-3">
                <label>Email:</label>
                <p>{{ $user->email }}</p>
            </div>

            <!-- Mobile -->
            <div class="mb-3">
                <label>Mobile:</label>
                @if($user->mobile)
                <p>{{ $user->mobile }}</p>
                @else
                <input type="text" name="mobile" class="form-control">
                @endif
            </div>

            <!-- DOB -->
            <div class="mb-3">
                <label>Date of Birth:</label>
                @if($user->dob)
                <p>{{ $user->dob }}</p>
                @else
                <input type="date" name="dob" class="form-control">
                @endif
            </div>

            <!-- Gender -->
            <div class="mb-3">
                <label>Gender:</label>
                @if($user->gender)
                <p>{{ $user->gender }}</p>
                @else
                <select name="gender" class="form-control">
                    <option value="">-- Select --</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select>
                @endif
            </div>

            <!-- Profile Photo -->
            <div class="mb-3">
                <label>Profile Photo:</label>
                @if($user->profile_photo)
                <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="Profile Photo" style="width: 100px;">
                @else
                <input type="file" name="profile_photo" class="form-control">
                @endif
            </div>

            <button type="submit" class="btn btn-primary">Submit Missing Info</button>
        </form>
    </div>
    @endsection


</body>

</html>