<div class="row align-items-center my-2">
    <div class="col-md-{{ $col1 ?? 4 }}">
        <label>{{ $label }}</label>
    </div>
    <div class="col-md-{{ $col2 ?? 6 }}">
        <select name="{{$name}}" id="{{$name}}" class="form-select">
            <option value="" disabled selected>{{$placeholder ?? 'Pilih...'}}</option>
            {!!$options!!}
        </select>
        <div></div>
    </div>
</div>
