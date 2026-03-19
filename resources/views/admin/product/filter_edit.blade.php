<label for="name">{{trans('main.sub_category')}}</label>
<select name="sub_category_id" class="form-control select2-show-search form-select" data-placeholder="Choose one">
    <option selected disabled>--</option>
    @foreach($subs as $sub)
        <option value="{{$sub->id}}">{{$sub->name}}</option>
    @endforeach
</select>