@extends('frontend.layouts.app')

@section('title', __('Subscription Confirmation'))

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-12 text-center">
                <h1 class="mt-5 mb-5">@lang('Thank you for subscribing to your new plan!')</h1>
                <h2 class="mb-5"><x-utils.link :href="route('frontend.plan')" :text="__('See Your Plan')" /></h2>
                <h1><i class="far fa-check-circle fa-5x" style="color: green"></i></h1>
            </div><!--col-md-10-->
        </div><!--row-->
    </div><!--container-->
@endsection