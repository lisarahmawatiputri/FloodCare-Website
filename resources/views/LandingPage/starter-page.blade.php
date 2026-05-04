@extends('LandingPage.layouts.app')

@section('title', 'Starter Page - FlexStart')
@section('body_class', 'starter-page-page')

@section('content')

    @include('LandingPage.partials.header')

    <main class="main">

        <!-- Page Title -->
        <div class="page-title">
            <div class="heading">
                <div class="container">
                    <div class="row d-flex justify-content-center text-center">
                        <div class="col-lg-8">
                            <h1>Starter Page</h1>
                            <p class="mb-0">Odio et unde deleniti. Deserunt numquam exercitationem. Officiis quo odio sint voluptas consequatur ut a odio voluptatem. Sit dolorum debitis veritatis natus dolores. Quasi ratione sint. Sit quaerat ipsum dolorem.</p>
                        </div>
                    </div>
                </div>
            </div>
            <nav class="breadcrumbs">
                <div class="container">
                    <ol>
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li class="current">Starter Page</li>
                    </ol>
                </div>
            </nav>
        </div>

        <!-- Starter Section -->
        <section id="starter-section" class="starter-section section">
            <div class="container section-title" data-aos="fade-up">
                <h2>Starter Section</h2>
                <p>Extended Section Title</p>
            </div>
            <div class="container" data-aos="fade-up">
                <p>Use this page as a starter for your own custom pages.</p>
            </div>
        </section>

    </main>

    @include('LandingPage.partials.footer')

@endsection