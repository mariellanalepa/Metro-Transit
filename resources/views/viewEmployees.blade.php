@extends('layouts.admin.employees')

@section('content')
@include('common.status')
<h3>Employees</h3>
<hr>
<!-- Employee Table -->
<!-- Wrap it in table-responsive container -->
<div class="table-responsive text-center">
    {{ csrf_field() }}
    <table class="table" id="table">
        <!-- Table Header -->
        <thead>
            <tr>
                <th class="text-center">Employee Id</th>
                <th class="text-center">First Name</th>
                <th class="text-center">Last Name</th>
                <th class="text-center">Street Number</th>
                <th class="text-center">Street Name</th>
                <th class="text-center">City</th>
                <th class="text-center">State</th>
                <th class="text-center">Postcode</th>
                <th class="text-center">Phone Number</th>
                <th class="text-center">SIN</th>
                <th class="text-center">Type</th>
            </tr>
        </thead>
        <!-- Table Body -->
        <tbody>
        <!-- Display info for each employee -->
        @foreach($employees as $employee)
            <tr class="employee{{ $employee->employeeId }}">
                <td>{{ $employee->employeeId }}</td>
                <td>{{ $employee->firstName }}</td>
                <td>{{ $employee->lastName }}</td>
                <td>{{ $employee->streetNumber }}</td> 
                <td>{{ $employee->streetName }}</td>
                <td>{{ $employee->city }}</td>
                <td>{{ $employee->state }}</td>
                <td>{{ $employee->postcode }}</td>
                <td>{{ $employee->phoneNumber }}</td>
                <td>{{ $employee->sin }}</td>
                <td>{{ $employee->employeeType }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

@stop

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@stop


@section('js')
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" defer></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  
<script>  
    /* jQuery ready() method makes function available only after
         document is "ready", i.e., loaded 
     * 
     */
    $(document).ready(function() {
        // Use DataTable plugin to make table interactive
        var $table = $('#table').DataTable();
    });
</script>    

@stop
