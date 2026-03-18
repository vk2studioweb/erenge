@extends('Admin.Layouts.app')
@section('content')
<div class="container">

</div>
@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{ asset('js/Admin/charts.js') }}"></script>
@endpush
@push('styles')
<link href="{{ asset('css/Admin/charts.css') }}" rel="stylesheet">
@endpush