<?php

// Home
Breadcrumbs::register('home', function ($breadcrumbs) {
    $breadcrumbs->push('Home', route('home'));
});
Breadcrumbs::register('weather', function ($breadcrumbs) {
    $breadcrumbs->push('Weather', route('weather'));
});
Breadcrumbs::register('tmu', function ($breadcrumbs) {
    $breadcrumbs->push('TMU Map', route('tmu'));
});