<!-- Check in Seesion Message -->
@if (session()->has('message'))
    <div class="alert alert-{{ session('type')}} alert-dismissible fade show text-center" role="alert">
        <strong>{{ session('message')}} </strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif



<!-- Error Message -->
@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{-- <h4 class="text-center"><strong> {{ session('error_message')}}!</strong></h4> --}}
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
<!-- Error Message -->
