@if (session('status'))
    <div class="alert alert-success info-message">
        {{ session('status') }}
    </div>
@endif
@if (session('warning'))
    <div class="alert alert-warning info-message">
        {{ session('warning') }}
    </div>
@endif

@if(count($errors) > 0)
    @foreach($errors->all() as $error)
        <div class="alert alert-warning info-message">
            {{ $error }}
        </div>
    @endforeach
@endif