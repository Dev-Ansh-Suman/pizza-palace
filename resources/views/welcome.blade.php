<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('head')
    </head>
    <body data-url="{{url('/')}}">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1 class="text-center page-heading">The Yummy Pizza</h1>
                </div>
                @include('header')
                @include('search')
            </div>
            <div class="row product-list" style="padding-top: 35px;">
                
            </div>
        </div>
    </body>
    @include('script')
</html>
