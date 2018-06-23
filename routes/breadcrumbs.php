<?php

// Home
Breadcrumbs::register('home', function ($breadcrumbs) {
    $breadcrumbs->push('Home', route('home'));
});
Breadcrumbs::register('weather', function ($breadcrumbs) {
    $breadcrumbs->push('Weather', route('weather'));
});