@php
$item=(object)$item
@endphp
<div class="row mb-3">
    <div class="col-md-12">
    @if($item->type=='text')
        <label for="fr{{$item->name}}" class="form-label">{{__($item->text)}}</label>
        <input type="text"
        name="{{$item->name}}"
        value="{{ old($item->name,((isset($item->value))?($item->value):(''))) }}"
        class="form-control @error($item->name) is-invalid @enderror @if (isset($item->class)) @if (strlen($item->class)>0) {{$item->class}} @endif @endif" id="fr{{$item->name}}"
        @if (isset($item->required)) @if (strlen($item->required)) required @endif @endif >

        @error($item->name)
        <div class="alert alert-primary d-flex align-items-center" role="alert">
            <div>
            {{ $message }}
            </div>
        </div>
        @enderror
    @endif


    @if($item->type=='money')
        <label for="fr{{$item->name}}" class="form-label">{{__($item->text)}}</label>
        <input type="number" min="0.00" max="10000.00" step="0.01"
        name="{{$item->name}}"
        value="{{ old($item->name,((isset($item->value))?($item->value):(''))) }}"
        class="form-control @error($item->name) is-invalid @enderror @if (isset($item->class)) @if (strlen($item->class)>0) {{$item->class}} @endif @endif" id="fr{{$item->name}}"
        @if (isset($item->required)) @if (strlen($item->required)) required @endif @endif >

        @error($item->name)
        <div class="alert alert-primary d-flex align-items-center" role="alert">
            <div>
            {{ $message }}
            </div>
        </div>
        @enderror
    @endif


    @if ($item->type=='textarea')
        <label for="fr{{$item->name}}" class="form-label">{{ __($item->text) }}</label>
    <textarea class="form-control" id="fr{{$item->name}}"
    name="{{$item->name}}"
    @error($item->name) is-invalid @enderror" id="fr{{$item->name}}"
    @if (isset($item->required)) @if (strlen($item->required)) required @endif @endif
    autocomplete="{{$item->name}}"
    >{{ old($item->name,((isset($item->value))?($item->value):(''))) }}</textarea>

    @error($item->name)
        <div class="alert alert-primary d-flex align-items-center" role="alert">
            <div>
            {{ $message }}
            </div>
        </div>
        @enderror
    @endif


    @if($item->type=='email')
        <label for="fr{{$item->name}}" class="form-label">{{__($item->text)}}</label>
        <input type="email"
        name="{{$item->name}}"
        value="{{ old($item->name,((isset($item->value))?($item->value):(''))) }}"
        class="form-control @error($item->name) is-invalid @enderror @if (isset($item->class)) @if (strlen($item->class)>0) {{$item->class}} @endif @endif" id="fr{{$item->name}}"
        @if (isset($item->required)) @if (strlen($item->required)) required @endif @endif >

        @error($item->name)
        <div class="alert alert-primary d-flex align-items-center" role="alert">
            <div>
            {{ $message }}
            </div>
        </div>
        @enderror
    @endif


    @if($item->type=='password')
        <label for="fr{{$item->name}}" class="form-label">{{__($item->text)}}</label>
        <input type="password"
        name="{{$item->name}}"
        value="{{ old($item->name,((isset($item->value))?($item->value):(''))) }}"
        class="form-control @error($item->name) is-invalid @enderror @if (isset($item->class)) @if (strlen($item->class)>0) {{$item->class}} @endif @endif" id="fr{{$item->name}}"
        @if (isset($item->required)) @if (strlen($item->required)) required @endif @endif >

        @error($item->name)
        <div class="alert alert-primary d-flex align-items-center" role="alert">
            <div>
            {{ $message }}
            </div>
        </div>
        @enderror
    @endif


    @if($item->type=='select' && isset($item->options))
    <label for="fr{{$item->name}}">{{ __($item->text) }}</label>

    <select name="{{$item->name}}"
        class="form-control  @error($item->name) is-invalid @enderror" id="fr{{$item->name}}"
        @if (isset($item->required)) @if (strlen($item->required)) required @endif @endif>
        <option>--{{__('Select')}}--</option>
        @foreach($item->options as $item->k=>$item->c)
        @php
        $item->vl=$item->c;
        if ($item->k!==null) $item->vl=$item->k;
        @endphp
        <option value="{{$item->vl}}" @if(( old($item->name,((isset($item->value))?($item->value):(''))) ==$item->vl ))
        selected
        @endif
        >{{__($item->c)}}</option>
        @endforeach
    </select>


    @error($item->name)
        <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
        </span>
    @enderror
    @endif

    @if($item->type=='date')
        <label for="fr{{$item->name}}">{{ __($item->text) }}</label>

        <input type="text" name="{{$item->name}}"
        class="datetimepicker form-control @error($item->name) is-invalid @enderror" id="fr{{$item->name}}"
        value="{{ old($item->name,((isset($item->value))?($item->value):(''))) }}"
            @if (isset($item->required)) @if (strlen($item->required)) required @endif @endif

            autocomplete="false"
            />

        @error($item->name)
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                </span>
        @enderror
    @endif


    @if($item->type=='dateTime')
        <label for="fr{{$item->name}}">{{ __($item->text) }}</label>

        <input type="text" name="{{$item->name}}"
        class="datetimepicker form-control @error($item->name) is-invalid @enderror" id="fr{{$item->name}}"
        value="{{ old($item->name,((isset($item->value))?($item->value):(''))) }}"
            @if (isset($item->required)) @if (strlen($item->required)) required @endif @endif

            autocomplete="false"
            />

        @error($item->name)
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                </span>
        @enderror
    @endif


    @if($item->type=='hidden')
        <input type="hidden" name="{{$item->name}}" id="fr{{$item->name}}"
        value="{{ old($item->name,((isset($item->value))?($item->value):(''))) }}">
    @endif
    </div>
</div>
