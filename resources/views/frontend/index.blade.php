@extends('frontend.master')

@section('frontend')

@include('frontend.home.home_slider')
<!--End hero slider-->
@include('frontend.home.feature_category')
<!--End category slider-->
@include('frontend.home.home_banner')
<!--End banners-->
@include('frontend.home.home_new_product')
<!--Products Tabs-->
@include('frontend.home.home_feature_product')
<!--End Best Sales-->

<!-- TV Category -->
@include('frontend.home.home_category_product')
<!--End TV Category -->
@include('frontend.home.hot_deal')
<!--End 4 columns-->

<!--Vendor List -->

@include('frontend.home.home_vendor')


<!--End Vendor List -->


@endsection
