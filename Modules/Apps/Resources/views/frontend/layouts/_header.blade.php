<!-- Start Header -->
<header>
    <div class="container">
        <div class="header">
            <a href="{{ url(route('frontend.home')) }}" class="logo wow zoomIn">
                <img src="{{ setting('logo') ? url(setting('logo')) : ''}}" alt="logo" class="img-fluid">
            </a>
            <div class="right-head wow fadeInUp" data-wow-delay="0.2s">
                <ul class="mo-nav fixall list-unstyled">
                    <li class="nav-li">
                        <a href="{{ url(route('frontend.categories.index')) }}" class="nav-anchor fixall">
                            {{ __('apps::frontend.navbar.categories') }}
                        </a>
                    </li>
                    <li class="nav-li">
                        <a href="{{ url(route('frontend.celebrities.featured')) }}" class="nav-anchor fixall">
                            {{ __('apps::frontend.navbar.featured') }}
                        </a>
                    </li>
                    <li class="nav-li">
                        <a href="{{ url(route('frontend.celebrities.pouplar')) }}" class="nav-anchor fixall">
                            {{ __('apps::frontend.navbar.pouplar') }}
                        </a>
                    </li>
                    <li class="nav-li">
                        <a href="{{ url(route('frontend.celebrities.newcomer')) }}" class="nav-anchor fixall">
                            {{ __('apps::frontend.navbar.newcomer') }}
                        </a>
                    </li>
                    <li class="nav-li drop-down">
                        <a href="#!" class="nav-anchor fixall">{{ LaravelLocalization::getCurrentLocaleNative() }}</a>
                        <div class="menu-dropdown">
                            @foreach (config('laravellocalization.supportedLocales') as $localeCode => $properties)
                            <a hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                {{ $properties['native'] }}
                            </a>
                            @endforeach
                        </div>
                    </li>
                    <li class="nav-li drop-down">
                        <a href="#!" class="nav-anchor fixall">{{ currentCurrency() }}</a>
                        <div class="menu-dropdown">
                            @foreach (setting('currencies') as $code)
                              <a href="{{ url(route('frontend.convert.currency',$code)) }}">
                                  {{ $code }}
                              </a>
                            @endforeach
                        </div>
                    </li>
                </ul>
                <div class="serch-ico">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="15.965" height="15.965" viewBox="0 0 15.965 15.965">
                        <g id="Mask_Group_31" data-name="Mask Group 31">
                            <path id="Shape"
                              d="M14.888,15.647a.766.766,0,0,1-.565-.229L9.611,10.724a.206.206,0,0,0-.044-.1.237.237,0,0,1-.05-.12,5.923,5.923,0,0,1-7.786-.488,5.837,5.837,0,0,1,0-8.3A5.933,5.933,0,0,1,5.936,0a5.873,5.873,0,0,1,4.617,9.463.248.248,0,0,1,.105.078.464.464,0,0,0,.084.077l4.711,4.693a.828.828,0,0,1,0,1.107A.766.766,0,0,1,14.888,15.647ZM5.936,1.564A4.273,4.273,0,0,0,1.6,5.868a4.273,4.273,0,0,0,4.334,4.3,4.182,4.182,0,0,0,3-1.26,4.361,4.361,0,0,0,0-6.085A4.181,4.181,0,0,0,5.936,1.564Z"
                              fill="#222B45" />
                        </g>
                    </svg>
                </div>
                <div class="mo-menu-ico">
                  <span></span>
                </div>
                <form class="search-cont" method="get" action="{{ url(route('frontend.celebrities.search')) }}">
                    <input name="search" type="text" class="search-input fixall" placeholder="{{ __('apps::frontend.navbar.search') }}">
                    <button type="submit" class="fixall search-button">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="15.965" height="15.965" viewBox="0 0 15.965 15.965">
                            <g id="Mask_Group_31" data-name="Mask Group 31">
                                <path id="Shape"
                                  d="M14.888,15.647a.766.766,0,0,1-.565-.229L9.611,10.724a.206.206,0,0,0-.044-.1.237.237,0,0,1-.05-.12,5.923,5.923,0,0,1-7.786-.488,5.837,5.837,0,0,1,0-8.3A5.933,5.933,0,0,1,5.936,0a5.873,5.873,0,0,1,4.617,9.463.248.248,0,0,1,.105.078.464.464,0,0,0,.084.077l4.711,4.693a.828.828,0,0,1,0,1.107A.766.766,0,0,1,14.888,15.647ZM5.936,1.564A4.273,4.273,0,0,0,1.6,5.868a4.273,4.273,0,0,0,4.334,4.3,4.182,4.182,0,0,0,3-1.26,4.361,4.361,0,0,0,0-6.085A4.181,4.181,0,0,0,5.936,1.564Z"
                                  fill="#fff" />
                            </g>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>
<!-- End Header -->
