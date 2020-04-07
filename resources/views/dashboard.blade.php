@extends('layouts.app')

@section('title', 'Dashboard')

@section('sidebar')
    @parent

    <p>Manage plants with ease.</p>
@endsection

@section('content')
    <section class="section">
        <div class="container">
            <div class="columns">
                <div class="column is-one-third">
                    <div class="card">
                        <header class="card-header">
                            <p class="card-header-title">
                              Tulpen
                            </p>
                            <a href="#" class="card-header-icon" aria-label="hide">
                              <span class="icon">
                                <i class="fas fa-angle-up" aria-hidden="true"></i>
                              </span>
                            </a>
                        </header>
                        <div class="card-content">
                            <div class="content">
                              <humidity-line-chart></humidity-line-chart>
                              <br>
                              <time datetime="2016-1-1">11:09 PM - 1 Jan 2016</time>
                            </div>
                        </div>
                        <footer class="card-footer">
                            <a href="#" class="card-footer-item">Settings</a>
                            <a href="#" class="card-footer-item">Details</a>
                            <a href="#" class="card-footer-item">Delete</a>
                        </footer>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
