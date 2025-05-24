@extends('apps::frontend.layouts.app')
@section('title', __('apps::frontend.home.title') )
@section('content')

<!-- start main -->
<main class="home">
    <div class="container">
        <div class="main-info">
            <h2 class="main-subhead fixall wow fadeInUp">
                {{ __('apps::frontend.home.slider.title1') }}
            </h2>
            <h1 class="main-head fixall wow fadeInUp" data-wow-delay="0.3s">
                {{ __('apps::frontend.home.slider.title2') }}
            </h1>
            <a href="{{ url(route('frontend.celebrities.index')) }}" class="find fixall wow fadeInUp" data-wow-delay="0.6s">
                {{ __('apps::frontend.home.slider.btn.find_more') }}
            </a>
        </div>
    </div>
</main>
<!-- end main -->

<!-- start discover section -->
<section>
    <div class="container">
        <div class="discover-sec">
            <h2 class="sec-head fixall wow fadeInUp">{{ __('apps::frontend.home.discover.header') }}</h2>
            <ul class="nav nav-tabs fixall wow fadeInUp" data-wow-delay="0.2s">
                <li class="fixall">
                    <a data-toggle="tab" href="#Pouplar" class="fixall tab-link">
                        {{ __('apps::frontend.home.discover.pouplar') }}
                    </a>
                </li>
                <li class=" fixall">
                    <a data-toggle="tab" href="#Featured" class="fixall tab-link active">
                        {{ __('apps::frontend.home.discover.featured') }}
                    </a>
                </li>
                <li class="fixall">
                    <a data-toggle="tab" href="#Newcomer" class="fixall tab-link">
                        {{ __('apps::frontend.home.discover.newcomer') }}
                    </a>
                </li>
            </ul>
            <div class="tab-content ">
                <div id="Pouplar" class="tab-pane fade pepole">
                    <div class="row">
                        @foreach ($pouplarCelebrities as $pouplarCelebrity)
                        <div class="col-md-3 col-sm-6 col-12">
                            <div class="person">
                                <a href="{{ url(route('frontend.celebrities.show',$pouplarCelebrity->profile->translate('en')->slug)) }}" class="person-img fixall">
                                    <img src="{{url($pouplarCelebrity->image)}}" class="img-fluid">
                                </a>
                                <div class="person-info">
                                    <a href="{{ url(route('frontend.celebrities.show',$pouplarCelebrity->profile->translate('en')->slug)) }}" class="person-name fixall">
                                      {{ $pouplarCelebrity->profile->translate(locale())->name }}
                                    </a>
                                    <div class="preson-cats">
                                        <a href="#!" class="fixall job">
                                            {{$pouplarCelebrity->profile->translate(locale())->job_title}}
                                        </a>
                                    </div>
                                    <span class="price-num">{{ currency($pouplarCelebrity->profile->price) }}</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <a href="{{ url(route('frontend.celebrities.pouplar')) }}" class="more fixall">
                        {{ __('apps::frontend.home.discover.btn.more') }}
                    </a>
                </div>
                <div id="Featured" class="tab-pane fade in active pepole show">
                    <div class="row wow fadeIn" data-wow-delay="0.4s">
                        @foreach ($featuredCelebrities as $featuredCelebrity)
                        <div class="col-md-3 col-sm-6 col-12">
                            <div class="person">
                                <a href="{{ url(route('frontend.celebrities.show',$featuredCelebrity->profile->translate('en')->slug)) }}" class="person-img fixall">
                                    <img src="{{url($featuredCelebrity->image)}}" class="img-fluid">
                                </a>
                                <div class="person-info">
                                    <a href="{{ url(route('frontend.celebrities.show',$featuredCelebrity->profile->translate('en')->slug)) }}" class="person-name fixall">
                                      {{ $featuredCelebrity->profile->translate(locale())->name }}
                                    </a>
                                    <div class="preson-cats">
                                        <a href="#!" class="fixall job">
                                            {{$featuredCelebrity->profile->translate(locale())->job_title}}
                                        </a>
                                    </div>
                                    <span class="price-num">{{ currency($featuredCelebrity->profile->price) }}</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <a href="{{ url(route('frontend.celebrities.featured')) }}" class="more fixall wow fadeInUp">
                        {{ __('apps::frontend.home.discover.btn.more') }}
                    </a>
                </div>
                <div id="Newcomer" class="tab-pane fade pepole">
                    <div class="row">
                        @foreach ($celebrities as $celebrity)
                        <div class="col-md-3 col-sm-6 col-12">
                            <div class="person">
                                <a href="{{ url(route('frontend.celebrities.show',$celebrity->profile->translate('en')->slug)) }}" class="person-img fixall">
                                    <img src="{{url($celebrity->image)}}" class="img-fluid">
                                </a>
                                <div class="person-info">
                                    <a href="{{ url(route('frontend.celebrities.show',$celebrity->profile->translate('en')->slug)) }}" class="person-name fixall">
                                      {{ $celebrity->profile->translate(locale())->name }}
                                    </a>
                                    <div class="preson-cats">
                                        <a href="#!" class="fixall job">
                                            {{$celebrity->profile->translate(locale())->job_title}}
                                        </a>
                                    </div>
                                    <span class="price-num">{{ currency($celebrity->profile->price) }}</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <a href="{{ url(route('frontend.celebrities.newcomer')) }}" class="more fixall">
                        {{ __('apps::frontend.home.discover.btn.more') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- end discover section -->

<!-- start ctas section -->
<section>
    <div class="container">
        <div class="cats-sec">
            <h2 class="sec-head fixall wow fadeInUp">
                {{ __('apps::frontend.home.categories.header') }}
            </h2>
            <div class="row wow fadeIn" data-wow-delay="0.2s">
                @foreach ($mainCategories as $category)
                <div class="col-md-3 col-6">
                    <a href="{{ url(route('frontend.categories.show',$category->translate(locale())->slug )) }}" class="cat fixall">
                        <img src="{{url($category->image)}}" class="img-fluid">
                        <span>{{ $category->translate(locale())->title }}</span>
                    </a>
                </div>
                @endforeach
            </div>
            <a href="{{ url(route('frontend.categories.index')) }}" class="more fixall wow fadeInUp" data-wow-delay="0.4s">
                {{ __('apps::frontend.home.categories.btn.more') }}
            </a>
        </div>
    </div>
</section>
<!-- end ctas section -->

@stop
