<br>
@if(isset($data['tag']))
    <div class="form-group">
        <div class="fg-line">
            <label class="fg-label">Tag</label>
            <input type="text" class="form-control" name="id" id="tag" value="{{ $data['id'] }}" placeholder="Tag">
        </div>
    </div>

    <br>
@endif
<div class="form-group">
    <div class="fg-line">
        <label class="fg-label">Location</label>
        <input type="text" class="form-control" name="location_name" id="location" value="{{ $data['location_name'] }}" placeholder="Enter Your Location">
    </div>
</div>

<br>