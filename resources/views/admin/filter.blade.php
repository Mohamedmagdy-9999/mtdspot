@foreach($units as $unit)

    <option value="{{$unit->id}}">{{$unit->unit_name}}</option>

@endforeach