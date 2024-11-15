@extends('frontend.layouts.master')

@section('title')
    {{ $settings->site_name ?? 'Default Site Name' }} || Home
@endsection

@section('content')
    @include('frontend.home.sections.banner-slider')
    @include('frontend.home.sections.flash-sale')
    @include('frontend.home.sections.top-category-product')
    @include('frontend.home.sections.brand-slider')
    @include('frontend.home.sections.single-banner')
    @include('frontend.home.sections.hot-deals')
    @include('frontend.home.sections.category-product-slider-1')
    @include('frontend.home.sections.category-product-slider-2')
    @include('frontend.home.sections.large-banner')
    @include('frontend.home.sections.weekly-best-item')
    @include('frontend.home.sections.services')
    @include('frontend.home.sections.blog')
@endsection
