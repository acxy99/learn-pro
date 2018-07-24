@if (session()->has('success'))
    <div class="container pt-4" dusk="alert-message">
        <div class="alert alert-success text-center br-0 mb-0">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <span class="font-weight-light">{!! session()->get('success') !!}</span>
        </div>
    </div>
@endif