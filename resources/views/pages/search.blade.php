@extends('layouts.master')


@section('content')

<div class="container">
    <h2 class="text-center">Vaccine Registration Status</h2>
    <br><br>

    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            @include('includes.alert_message')

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('searchProcess') }}" method="post">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label"><b>NID</b></label>
                            <input type="text" name="nid" required class="form-control" placeholder="Ex:123456789">
                        </div>
                        <br>
                        <div class="mb-3">
                            <div class="d-grid gap-2">
                                <button class="btn btn-success" type="submit">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-3"></div>
    </div>


    <div class="mt-5 row">
        <div class="col-3"></div>
        <div class="col-6">
            @if(isset($userData))
                <table class="table">
                    <tr>
                        <th scope="col">Name</th>
                        <td>{{ $userData->name }}</td>
                    </tr>
                    <tr>
                        <th scope="col">Email</th>
                        <td>{{ $userData->email }}</td>
                    </tr>
                    <tr>
                        <th scope="col">NID</th>
                        <td>{{ $userData->nid }}</td>
                    </tr>
                    <tr>
                        <th scope="col">Status</th>
                        <td>
                            @if ($vaccineStatus==='Scheduled')
                                <span class="p-2 badge bg-primary">{{ $vaccineStatus }}</span>
                            @elseif ($vaccineStatus==='Not scheduled')
                                <span class="p-2 badge bg-danger">{{ $vaccineStatus }}</span>
                            @elseif ($vaccineStatus==='Vaccinated')
                                <span class="p-2 badge bg-success">{{ $vaccineStatus }}</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th scope="col">Date</th>
                        <td>{{ $userData->scheduled_date }}</td>
                    </tr>
                    <tr>
                        <th scope="col">Center Name</th>
                        <td>{{ $userData->vaccineCenter->name }}</td>
                    </tr>
                </table>
            @elseif(isset($vaccineStatus) && $vaccineStatus === 'Not registered')
                <div class="alert alert-danger" role="alert">
                    Not registered. <a href="{{ route('registration') }}">Click Here</a> to registration.
                </div>
            @endif
        </div>
        <div class="col-3"></div>
    </div>
</div>

@endsection
