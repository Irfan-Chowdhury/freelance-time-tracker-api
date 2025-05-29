@extends('layouts.master')

@section('content')
<div class="container">
    <h2 class="text-center">Vaccine Center List</h2>

    <div class="mt-5 row">
        <div class="col-12">
            <table id="dataTable" class="table">
                <thead>
                <tr>
                    <th scope="col">#SL</th>
                    <th scope="col">Center Name</th>
                    <th scope="col">Address</th>
                    <th scope="col">Daily Limit</th>
                </tr>
                </thead>
                <tbody>
                    @forelse ($vaccineCenters as $key => $item)
                        <tr>
                            <th scope="row">{{$key+1}}</th>
                            <td>{{$item->name}}</td>
                            <td>{{$item->address}}</td>
                            <td>{{$item->daily_limit}}</td>
                        </tr>
                    @empty
                        <tr>
                            <td></td>
                            <td class="text-danger">No Data Found</td>
                            <td></td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')

    <script>
        $(document).ready(function () {
            $('#dataTable').DataTable();
        });
    </script>

@endpush
