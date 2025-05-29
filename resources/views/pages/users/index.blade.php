@extends('layouts.master')

@section('content')
<div class="container">
    <h2 class="text-center">All Users</h2>

    <div class="mt-5 row">
        <div class="col-12">
            <table id="dataTable" class="table">
                <thead>
                <tr>
                    <th scope="col">#SL</th>
                    <th scope="col">NID No</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Gender</th>
                    <th scope="col">Vaccine Date</th>
                    <th scope="col">Vaccine Status</th>
                </tr>
                </thead>
                <tbody>
                    @forelse ($users as $key => $item)
                        <tr>
                            <th scope="row">{{$key+1}}</th>
                            <td>{{$item->nid}}</td>
                            <td>{{$item->name}}</td>
                            <td>{{$item->email}}</td>
                            <td>{{$item->gender}}</td>
                            <td>{{$item->scheduled_date}}</td>
                            <td>
                                @if ($item->vaccine_status ==='Scheduled')
                                    <span class="p-2 badge bg-primary">{{ $item->vaccine_status }}</span>
                                @elseif ($item->vaccine_status==='Not scheduled')
                                    <span class="p-2 badge bg-warning">{{ $item->vaccine_status }}</span>
                                @elseif ($item->vaccine_status==='Vaccinated')
                                    <span class="p-2 badge bg-success">{{ $item->vaccine_status }}</span>
                                @endif
                            </td>
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
