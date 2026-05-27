@extends('LandingPage.Layouts.app')

@section('title', 'FloodCare')

@section('content')
    @include('LandingPage.Partials.hero')
    @include('LandingPage.Partials.features')
    @include('LandingPage.Partials.faq')
    @include('LandingPage.Partials.cta')
@endsection