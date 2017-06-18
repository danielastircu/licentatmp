<h4 data-toggle="collapse" data-target="#generalData"><span
            class="glyphicon arrow glyphicon-chevron-down"></span>General
    Values</h4>
<div id="generalData" class="collapse in">
    <div class="content-collapse">
        <div class="form-group row">
            <label for="example-text-input" class="col-md-12 col-form-label"><span class="blue">Name</span></label>
            <div class="col-md-12">
                <input class="form-control" type="text" value="{{$data['name']}}" id="example-text-input" name="name">
            </div>
        </div>
    </div>
</div>

<h4 data-toggle="collapse" data-target="#nutrition"><span
            class="glyphicon arrow glyphicon-chevron-down"></span>Nutritional
    Values
    <button class="btn btn-primary get-data-picture btn-xs" data-forTarget="nutrition"><span
                class="glyphicon glyphicon-plus"></span>Get Data From Picture
    </button>
</h4>
<div id="nutrition" class="collapse in">
    <div class="content-collapse">
        <div class="form-group row">
            <label for="example-text-input" class="col-md-9 col-form-label"><span
                        class="blue">Energy ( kJ )</span></label>
            <div class="col-md-3">
                <input class="form-control" type="text" value="{{$data['kJ']}}" name="kJ" id="example-text-input">
            </div>
        </div>
        <div class="form-group row">
            <label for="example-text-input" class="col-md-9 col-form-label"><span
                        class="blue">Energy ( kCal )</span></label>
            <div class="col-md-3">
                <input class="form-control" type="text" value="{{$data['kCal']}}" name="kCal" id="example-text-input">
            </div>
        </div>
        <hr>
        <div class="form-group row">
            <label for="example-text-input" class="col-md-9 col-form-label"><span class="blue">Fat</span>:</label>
            <div class="col-md-3">
                <input class="form-control" type="text" value="{{$data['fat']}}" name="fat" id="example-text-input">
            </div>
        </div>
        <div class="form-group row">
            <label for="example-text-input" class="col-md-9 col-form-label">of which <span class="blue">Saturated fatty acids</span>:</label>
            <div class="col-md-3">
                <input class="form-control" type="text" value="{{$data['saturated']}}" name="saturated"
                       id="example-text-input">
            </div>
        </div>
        <div class="form-group row">
            <label for="example-text-input" class="col-md-9 col-form-label">of which <span
                        class="blue">Cholesterol</span>:</label>
            <div class="col-md-3">
                <input class="form-control" type="text" value="{{$data['cholesterot']}}" name="cholesterot"
                       id="example-text-input">
            </div>
        </div>
        <div class="form-group row">
            <label for="example-text-input" class="col-md-9 col-form-label">of which <span class="blue">Monounsaturated fatty
                acids</span>:</label>
            <div class="col-md-3">
                <input class="form-control" type="text" value="{{$data['monounsaturated']}}" name="monounsaturated"
                       id="example-text-input">
            </div>
        </div>
        <div class="form-group row">
            <label for="example-text-input" class="col-md-9 col-form-label">of which<span class="blue"> Polyunsaturated fatty
                acids</span>:</label>
            <div class="col-md-3">
                <input class="form-control" type="text" value="{{$data['polyunsaturated']}}" name="polyunsaturated"
                       id="example-text-input">
            </div>
        </div>
        <div class="form-group row">
            <label for="example-text-input" class="col-md-9 col-form-label">of which <span class="blue">Trans-fatty acids</span>:</label>
            <div class="col-md-3">
                <input class="form-control" type="text" value="{{$data['trans']}}" name="trans" id="example-text-input">
            </div>
        </div>
        <hr>
        <div class="form-group row">
            <label for="example-text-input" class="col-md-9 col-form-label"><span
                        class="blue">Carbohydrates</span>:</label>
            <div class="col-md-3">
                <input class="form-control" type="text" value="{{$data['carbohydrates']}}" name="carbohydrates"
                       id="example-text-input">
            </div>
        </div>
        <div class="form-group row">
            <label for="example-text-input" class="col-md-9 col-form-label">of which <span
                        class="blue">Sugar</span>:</label>
            <div class="col-md-3">
                <input class="form-control" type="text" value="{{$data['sugar']}}" name="sugar" id="example-text-input">
            </div>
        </div>
        <div class="form-group row">
            <label for="example-text-input" class="col-md-9 col-form-label">of which <span class="blue">Polyhydric alcohols</span>:</label>
            <div class="col-md-3">
                <input class="form-control" type="text" value="{{$data['polyhydric']}}" name="polyhydric"
                       id="example-text-input">
            </div>
        </div>
        <div class="form-group row">
            <label for="example-text-input" class="col-md-9 col-form-label">of which <span
                        class="blue">Starch</span>:</label>
            <div class="col-md-3">
                <input class="form-control" type="text" value="{{$data['starch']}}" name="starch"
                       id="example-text-input">
            </div>
        </div>
        <hr>
        <div class="form-group row">
            <label for="example-text-input" class="col-md-9 col-form-label"><span
                        class="blue">Dietary Fibre(Fiber)</span>:</label>
            <div class="col-md-3">
                <input class="form-control" type="text" value="{{$data['fiber']}}" name="fiber" id="example-text-input">
            </div>
        </div>
        <hr>
        <div class="form-group row">
            <label for="example-text-input" class="col-md-9 col-form-label"><span class="blue">Protein</span>:</label>
            <div class="col-md-3">
                <input class="form-control" type="text" value="{{$data['protein']}}" name="protein"
                       id="example-text-input">
            </div>
        </div>
        <hr>
        <div class="form-group row">
            <label for="example-text-input" class="col-md-9 col-form-label"><span class="blue">Salt</span>:</label>
            <div class="col-md-3">
                <input class="form-control" type="text" value="{{$data['salt']}}" name="salt" id="example-text-input">
            </div>
        </div>
    </div>
</div>





