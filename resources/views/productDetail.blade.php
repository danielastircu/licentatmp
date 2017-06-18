<h4 data-toggle="collapse" data-target="#description{{$language}}">
    <span class="glyphicon arrow glyphicon-chevron-down"></span>Description
    <button class="btn btn-primary get-data-picture btn-xs" data-forTarget="detail[{{$language}}][description]"><span
                class="glyphicon glyphicon-plus"></span>Get Data From Picture
    </button>
</h4>
<div id="description{{$language}}" class="collapse in">
    <div class="content-collapse">
        <textarea class="form-control" id="exampleTextarea" rows="3"
                  name="detail[{{$language}}][description]">@if(!empty($data) ){{$data['description']}}@endif</textarea>
    </div>

</div>

<h4 data-toggle="collapse" data-target="#ingredients{{$language}}"><span
            class="glyphicon arrow glyphicon-chevron-down"></span>Ingredients
    <button class="btn btn-primary get-data-picture btn-xs" data-forTarget="detail[{{$language}}][description]"><span
                class="glyphicon glyphicon-plus"></span>Get Data From Picture
    </button>
</h4>

<div id="ingredients{{$language}}" class="collapse in">
    <div class="content-collapse">
        <textarea class="form-control" id="exampleTextarea" rows="3"
                  name="detail[{{$language}}][allergens]">@if(!empty($data) ){{$data['allergens']}}@endif</textarea>
    </div>
</div>


<h4 data-toggle="collapse" data-target="#allergens{{$language}}"><span
            class="glyphicon arrow glyphicon-chevron-down"></span>Allergens
    <button class="btn btn-primary get-data-picture btn-xs" data-forTarget="detail[{{$language}}][description]"><span
                class="glyphicon glyphicon-plus"></span>Get Data From Picture
    </button>
</h4>

<div id="allergens{{$language}}" class="collapse in">
    <div class="content-collapse">
        <textarea class="form-control" id="exampleTextarea" rows="3"
                  name="detail[{{$language}}][ingredients]">@if(!empty($data) ){{$data['ingredients']}}@endif</textarea>
    </div>
</div>

<input type="hidden" name="detail[{{$language}}][id]" value="{{ $data['id'] }}">



