@extends('depan.cork.index')
@section('isi')
<!--uiop-->
<div class="row layout-top-spacing">
    <div class='col-xl-3 col-lg-4 col-md-6'>
        <div class="search-input-group-style input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" class="feather feather-search">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg></span>
            </div>
            <input type="text" class="form-control" placeholder="Let's find your question in fast way"
                aria-label="Username" aria-describedby="basic-addon1">
        </div>
    </div>
</div>
<!--uiop-->
@endsection