<html>
    @section('title',__('authentication::frontend.reset.form.btn.reset'))
    <link rel="stylesheet" href="{{ url('admin/assets/pages/css/login.min.css') }}">
    @include('apps::dashboard.layouts._head_rtl')
    <body class="login">
        <div class="content">
            <form class="login-form" method="POST" action="{{ route('frontend.password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <h3 class="form-title font-green">{{ __('authentication::frontend.reset.form.btn.reset') }}</h3>
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label class="control-label">
                      {{ __('authentication::dashboard.login.form.email') }}
                    </label>
                    <input class="form-control form-control-solid placeholder-no-fix" type="text" value="{{ old('email') }}" name="email"/>
                    @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group{{$errors->has('password') ? ' has-error' : ''}}">
                    <label class="control-label">
                      {{ __('authentication::dashboard.login.form.password') }}
                    </label>
                    <input class="form-control form-control-solid placeholder-no-fix" type="password" name="password"/>
                    @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group{{$errors->has('password_confirmation') ? ' has-error' : ''}}">
                    <label class="control-label">
                    {{ __('authentication::frontend.reset.form.password_confirmation') }}
                    </label>
                    <input class="form-control form-control-solid placeholder-no-fix" type="password" name="password_confirmation"/>
                    @if ($errors->has('password_confirmation'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn green uppercase">
                      {{ __('authentication::frontend.reset.form.btn.reset') }}
                    </button>
                </div>
            </form>
        </div>
        @include('apps::dashboard.layouts._footer')
        @include('apps::dashboard.layouts._jquery')
    </body>
</html>
