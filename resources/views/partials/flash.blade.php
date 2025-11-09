@if(session('status'))
    <div class="container pt-5">
        <div class="alert alert-success shadow-sm border-0 rounded-4">{{ session('status') }}</div>
    </div>
@endif
@if($errors->any())
    <div class="container pt-5">
        <div class="alert alert-danger shadow-sm border-0 rounded-4">
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif
