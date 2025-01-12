@extends('admin.home')

@section('registrator')
<style>

</style>
<div class="title d-flex align-items-center justify-content-between">
    <h1 class="my-4 mx-auto fw-bold">Registrator</h1>
    <a href="{{ route('registrator.create') }}" class="btn btn-success btn mx-5">Add</a>
</div>
@endsection
