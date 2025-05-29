@extends('layouts.master')

@section('content')
    <div class="container">
        <h2 class="text-center">Final Step : Confirmation</h2>

        @include('includes.alert_message')


        <div class="card mt-5">
            <div class="card-body">

                <form action="{{ route('vaccine-registration.confirmationProcess') }}" method="post">
                    @csrf

                    <input type="hidden" name="requestData" value="{{ $request }}">
                    <input type="hidden" name="nid" value="{{ $request->nid }}">
                    <input type="hidden" name="date_of_birth" value="{{ $request->date_of_birth }}">
                    <input type="hidden" name="name" value="{{ $request->name }}">
                    <input type="hidden" name="gender" value="{{ $request->gender }}">
                    <input type="hidden" name="mobile" value="{{ $request->mobile }}">
                    <input type="hidden" name="email" value="{{ $request->email }}">
                    <input type="hidden" name="vaccine_center_id" value="{{ $request->vaccine_center_id }}">
                    <input type="hidden" name="system_otp" value="{{ $otp }}">

                    {{-- <h1>Test - {{ $otp }}</h1> --}}

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">A 6 digit OTP number has been sent this <b>{{ $request->email }}</b> mail. Please check and fillup</label>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="exampleFormControlInput1" class="form-label">OTP</label>
                            <input type="number" required name="user_otp" class="form-control" placeholder="Ex: 123456">
                        </div>

                        <div class="col-md-12 mb-3">
                            <div class="d-grid gap-2">
                                <button class="btn btn-success" type="submit">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>

    </div>



@endsection
