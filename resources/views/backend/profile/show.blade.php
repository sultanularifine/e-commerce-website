@extends('backend.layouts.app')
@section('title', 'Profile')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Profile</h1>
            </div>

            <div class="card card-primary">
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <div class="row">
                        <div class="col-md-4 text-center">
                            <img src="{{ $user->avatar ? asset('uploads/avatars/' . $user->avatar) : asset('backend/images/default-avatar.png') }}"
                                alt="Avatar" class="img-fluid rounded-circle mb-2" style="width:150px;height:150px;">
                        </div>
                        <div class="col-md-8">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Name</th>
                                    <td>{{ $user->name }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $user->email }}</td>
                                </tr>
                                <tr>
                                    <th>Role</th>
                                    <td>{{ $user->roles->pluck('name')->join(', ') ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Password</th>
                                    <td>
                                        <span id="password-field">********</span>
                                        <button type="button" class="btn btn-sm btn-outline-secondary"
                                            onclick="togglePassword()" style="margin-left:5px;">
                                            <i id="eye-icon" class="fa fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                            </table>

                            <a href="{{ route('settings.index') }}" class="btn btn-primary mt-3">Edit Profile</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script>
        let passwordVisible = false;

        function togglePassword() {
            const passwordField = document.getElementById('password-field');
            const eyeIcon = document.getElementById('eye-icon');

            if (passwordVisible) {
                passwordField.textContent = '********';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
                passwordVisible = false;
            } else {
                // You cannot show the real password, show a placeholder instead
                passwordField.textContent = 'You cannot view your real password';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
                passwordVisible = true;
            }
        }
    </script>
@endsection
