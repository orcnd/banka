@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <form method="POST" action="{{$route}}">
                @csrf
                @each('components.form', $form, 'item')
                <div class="row mb-4">
                    <div class="col-md-8 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Save') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
