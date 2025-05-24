<!-- start footer -->
<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-12 wow fadeInUp">
                <div class="first-div">
                    <div class="logo">
                      <img src="{{ setting('logo') ? url(setting('logo')) : ''}}" alt="logo" class="img-fluid">
                    </div>
                    <div class="social">
                        <a href="{{ setting('social','facebook') }}" class="social-link fixall">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="16" height="16" viewBox="0 0 16 16">
                                <g id="Mask_Group_1" data-name="Mask Group 1" transform="translate(-1089 -6)" clip-path="url(#clip-path)">
                                    <path id="Facebook" d="M5.319,16H1.772V8.445H0V5.533H1.772V3.787C1.772,1.413,2.773,0,5.616,0H7.983V2.912H6.5c-1.107,0-1.181.406-1.181,1.166l0,1.456H8L7.686,8.445H5.319V16Z" transform="translate(1092.887 6)"
                                      fill="#fff" />
                                </g>
                            </svg>
                        </a>
                        <a href="{{ setting('social','twitter') }}" class="social-link fixall">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="16" height="16" viewBox="0 0 16 16">
                                <g id="Mask_Group_2" data-name="Mask Group 2" transform="translate(-1137 5)" clip-path="url(#clip-path)">
                                    <path id="Twitter"
                                      d="M16.094,1.548a6.623,6.623,0,0,1-1.9.52A3.311,3.311,0,0,0,15.649.242a6.6,6.6,0,0,1-2.1.8A3.3,3.3,0,0,0,7.84,3.3a3.338,3.338,0,0,0,.086.753A9.373,9.373,0,0,1,1.121.6,3.3,3.3,0,0,0,2.143,5.011,3.274,3.274,0,0,1,.648,4.6v.042A3.3,3.3,0,0,0,3.3,7.877a3.3,3.3,0,0,1-.87.116,3.248,3.248,0,0,1-.621-.06,3.307,3.307,0,0,0,3.085,2.293,6.633,6.633,0,0,1-4.1,1.412A6.655,6.655,0,0,1,0,11.593a9.344,9.344,0,0,0,5.062,1.483,9.329,9.329,0,0,0,9.394-9.392c0-.144,0-.285-.009-.427a6.711,6.711,0,0,0,1.647-1.708Z"
                                      transform="translate(1137 -3.667)" fill="#fff" />
                                </g>
                            </svg>
                        </a>
                        <a href="{{ setting('social','instagram') }}" class="social-link fixall">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="16" height="16" viewBox="0 0 16 16">
                                <g id="Mask_Group_3" data-name="Mask Group 3" transform="translate(-1131 -38)" clip-path="url(#clip-path)">
                                    <g id="Group_3" data-name="Group 3" transform="translate(1131 38)">
                                        <path id="Exclusion_34" data-name="Exclusion 34"
                                          d="M11.234,16H4.766A4.772,4.772,0,0,1,0,11.234V4.766A4.772,4.772,0,0,1,4.766,0h6.467A4.772,4.772,0,0,1,16,4.766v6.467A4.772,4.772,0,0,1,11.234,16ZM4.766,1.609A3.161,3.161,0,0,0,1.609,4.766v6.467A3.16,3.16,0,0,0,4.766,14.39h6.467a3.16,3.16,0,0,0,3.157-3.157V4.766a3.16,3.16,0,0,0-3.157-3.157ZM8,12.138A4.138,4.138,0,1,1,12.138,8,4.143,4.143,0,0,1,8,12.138ZM8,5.472A2.528,2.528,0,1,0,10.528,8,2.531,2.531,0,0,0,8,5.472Z"
                                          transform="translate(0 0)" fill="#fff" />
                                        <circle id="Oval-path" cx="0.992" cy="0.992" r="0.992" transform="translate(11.155 2.901)" fill="#fff" />
                                    </g>
                                </g>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6 wow fadeInUp" data-wow-delay="0.2s">
                <ul class="fixall list-unstyled foot-links">
                    <li class="foot-li">
                        <a href="{{ url(route('frontend.categories.index')) }}" class="foot-link fixall">
                            {{ __('apps::frontend.footer.categories') }}
                        </a>
                    </li>
                    @foreach ($pages as $page)
                    <li class="foot-li">
                        <a href="{{ url(route('frontend.pages.show',$page->translate(locale())->slug)) }}" class="foot-link fixall">{{ $page->translate(locale())->title }}</a>
                    </li>
                    @endforeach
                </ul>
            </div>
            <div class="col-md-3 offset-lg-1 col-md-5 offset-md-0 col-12 wow fadeInUp" data-wow-delay="0.6s">
                <span class="form-title">{{ __('apps::frontend.footer.join.title') }}</span>
                <form class="join-cont" method="get" action="{{ url(route('frontend.newsletter.create')) }}">
                    <input type="email" name="email" class="join-input fixall" placeholder="Email">
                    <button type="submit" class="fixall join-button">
                        {{ __('apps::frontend.footer.join.btn') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div class="copyright">
        {{ __('apps::frontend.footer.copy_rights') }}
        <a href="https://www.tocaan.com/" target="_blank">
          {{ __('apps::frontend.footer.tocaan_link') }}
        </a>
    </div>
</footer>
<!-- end footer -->
