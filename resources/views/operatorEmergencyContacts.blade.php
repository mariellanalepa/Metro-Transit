@extends('layouts.operator.profile')

@section('content')
<div class="container">
    <div class="col-sm-6">
        <!-- Emergency Contacts Table -->
        <div class="well well-lg">
            <div class="well-heading">
            Emergency Contacts
            </div>
            <div class="well-body">
                <table class="table table-striped">
                    <thead>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Phone Number</th>
                    </thead>
                    <tbody>
                        @foreach ($contacts as $contact)
                            <tr>
                                <td>{{ $contact->firstName }}</td>
                                <td>{{ $contact->lastName }}</td>
                                <td>{{ $contact->getPhoneNumber() }}</td>
                                <!-- Contact Delete Button -->
                                <td>
                                    <form action="emergencyContacts/{{ $contact->id }}" method="POST">
                                        {{ csrf_field() }}
                                        <!-- Way of telling Laravel we wish to use DELETE method -->
                                        {{ method_field('DELETE') }}
                                        <button type="submit" class="btn btn-danger">
                                            <span class="glyphicon glyphicon-remove"></span> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Add Emergency Contact -->
        <div class="well well-lg">
            <div class="well-heading">
                Add Emergency Contacts
            </div>

            <div class="well-body">
                <!-- Display Validation Errors -->
                @include('common.errors')
                @include('common.status')
                <!-- New Contact Form -->
                <form action="{{ url('emergencyContacts') }}" method="POST" class="form-horizontal">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="first-name" class="col-sm-3 control-label">First Name:</label>
                        <div class="col-sm-6">
                            <input type="text" name="firstName" id="first-name" class="form-control" value="{{ old('firstName')}}">
                        </div>
                        <!--
                        <span class="error">{!! $errors->first('firstName') !!}</span>
                        -->
                    </div>
                    <div class="form-group">
                        <label for="last-name" class="col-sm-3 control-label">Last Name:</label>
                        <div class="col-sm-6">
                            <input type="text" name="lastName" id="last-name" class="form-control" value="{{ old('lastName')}}">
                            <!--
                            <span class="error">{!! $errors->first('lastName') !!}</span>
                            -->
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="phone-number" class="col-sm-3 control-label">Phone number:</label>
                        <div class="col-sm-6">
                            <input type="text" name="phoneNumber" id="phone-number" class="form-control" value="{{ old('phoneNumber')}}">
                            <!--
                            <span class="error">{!! $errors->first('phoneNumber') !!}</span>
                            -->
                        </div>
                    </div>
                    <!-- Hidden form to retain user -->
                    <div class="form-group">
                            <input type="hidden" name="employeeId" class="form-control" value="{{ $employee->employeeId }}">
                    </div>
                    <!-- Add Contact Button -->
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-6">
                            <button type="submit" class="btn btn-success">
                                <span class="glyphicon glyphicon-ok"></span> Add Emergency Contact
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>     
    </div>
</div>
@stop


@section('css')
<style>
.well-heading {
    font-size: 30px;
}
</style>
@stop

@section('js')
<!-- Scripts -->
<script>
</script>    

@stop