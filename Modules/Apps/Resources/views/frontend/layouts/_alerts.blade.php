@if ($errors->all())
<div class="alert alert-danger" role="alert">
  <center>
      @foreach ($errors->all() as $error)
      <li><strong>{{ $error }}</strong></li>
      @endforeach
  </center>
</div>
@endif

@if (session('status'))
<div class="alert alert-{{session('alert')}}" role="alert">
    <center>
        {{ session('status') }}
    </center>
</div>
@endif
