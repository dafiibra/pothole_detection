@extends('layouts.user_page')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">User Management</div>

                <div class="card-body">
                    <!-- User Registration Requests -->
                    <div class="mb-4">
                        <h5>User Registration Requests</h5>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Username</th>
                                    <th>Full Name</th>
                                    <th>Email</th>
                                    <th>Division</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Loop through user registration requests -->
                                @foreach($registrationRequests as $user)
                                <tr>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->fullname }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->division }}</td>
                                    <td>{{ $user->status }}</td>
                                    <td>
                                        <a href="{{ route('approve-user', $user->username) }}" class="btn btn-success btn-sm">Approve</a>
                                        <a href="{{ route('reject-user', $user->username) }}" class="btn btn-danger btn-sm">Reject</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Approved Users -->
                    <div class="mb-4">
                        <h5>Approved Users</h5>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Username</th>
                                    <th>Full Name</th>
                                    <th>Email</th>
                                    <th>Division</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Loop through approved users -->
                                @foreach($approvedUsers as $user)
                                <tr>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->fullname }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->division }}</td>
                                    <td>
                                        <a href="{{ route('delete-user', $user->username) }}" class="btn btn-danger btn-sm">Delete</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- User Login Activity -->
                    <div>
                        <h5>User Login Activity</h5>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Username</th>
                                    <th>Activity Name</th>
                                    <th>IP Address</th>
                                    <th>Login Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Loop through user login activities -->
                                @foreach($loginActivities as $activity)
                                <tr>
                                    <td>{{ $activity->username }}</td>
                                    <td>{{ $activity->activity_name }}</td>
                                    <td>{{ $activity->ip_address }}</td>
                                    <td>{{ $activity->login_time }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection