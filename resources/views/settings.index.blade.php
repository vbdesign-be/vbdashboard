@if (session()->has('message'))
    {{ session()->get('message') }}
@endif

@if (session()->has('error'))
    {{ session()->get('error') }}
@endif

@if ($teamleader->shouldAuthorize())
    <form action="{{ route('settings.teamleader.authorize') }}" method="POST">
        @csrf
        <button type="submit">{{ __('default.teamleader.connect') }}</button>
    </form>
@else
    <p>You are already connected with Teamleader</p>
@endif