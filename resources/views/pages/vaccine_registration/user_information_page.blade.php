@extends('layouts.master')

@section('content')
    <div class="container">
        <h2 class="text-center">Step-2 : User Information</h2>

        @include('includes.alert_message')


        <div class="card mt-5">
            <div class="card-body">

                <form action="{{ route('vaccine-registration.confirmationPage') }}" method="post">
                    @csrf
                    <input type="hidden" name="nid" value="{{ $user->nid }}">
                    <input type="hidden" name="date_of_birth" value="{{ $user->date_of_birth }}">

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Name</label>
                            <input type="text" name="name" readonly value="{{ $user->name }}" class="form-control" placeholder="name@example.com">
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="mt-4 form-check form-check-inline">
                                <input class="form-check-input" onclick="return false;" name="gender" @if($user->gender=='male') checked @endif type="radio" value="male">
                                <label class="form-check-label">Male</label>
                              </div>
                              <div class="form-check form-check-inline">
                                <input class="form-check-input" onclick="return false;" name="gender"  @if($user->gender=='female') checked @endif type="radio" value="female">
                                <label class="form-check-label">Female</label>
                              </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Mobile</label>
                            <input type="number" required name="mobile" class="form-control" placeholder="0182-XXXX-XXX">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Email</label>
                            <input type="email" required name="email" class="form-control" placeholder="name@example.com">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Select Center</label>
                            <select required class="form-select" name="vaccine_center_id">
                                <option>--- Select  ---</option>
                                @foreach ($vaccineCenters as $item)
                                    <option value="{{$item->id}}">{{ $item->center_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="mt-5 form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="termAndCondition">
                                <label class="form-check-label">I accept all term & condition</label>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="d-grid gap-2">
                                <button class="btn btn-success" disabled id="submitButton" type="submit">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>

    </div>

@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#termAndCondition').change(function() {
                if ($(this).is(':checked')) {
                    $('#submitButton').prop('disabled', false);
                } else {
                    $('#submitButton').prop('disabled', true);
                }
            });
        });
    </script>

@endpush
