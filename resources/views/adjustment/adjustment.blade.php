@extends('layouts.simple.master')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/select2.css') }}">
@endsection

@section('breadcrumb-title')
    <h3>Ajustes</h3>
@endsection

@section('content')
    <adjustment-component></adjustment-component>
@endsection
