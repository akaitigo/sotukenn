@include('header')

<p>{{$employees}}</p>

@foreach($employees as $emp)
<p>{{$emp->employee_id}}</p>
<p>{{$emp->employee_name}}</p>
@endforeach