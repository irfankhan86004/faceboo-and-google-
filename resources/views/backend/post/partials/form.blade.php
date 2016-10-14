<br>

<div class="form-group">
    <div class="toggle-switch toggle-switch-demo" data-ts-color="blue">
        <label for="is_draft" class="ts-label">Draft?</label>
        <input {{ checked($is_draft) }} type="checkbox" name="is_draft">
        <label for="is_draft" class="ts-helper"></label>
    </div>
</div>

<br>

<div class="form-group">
    <div class="fg-line">
      <label class="fg-label">Title</label>
      <input type="text" class="form-control" name="title" id="title" value="{{ $title }}" placeholder="Title">
    </div>
</div>

<br>

<div class="form-group">
    <div class="fg-line">
      <label class="fg-label">Slug</label>
      <input type="text" class="form-control" name="slug" id="slug" value="{{ $slug }}" placeholder="Post Slug">
    </div>
</div>

<br>

<div class="form-group">
    <div class="fg-line">
      <label class="fg-label">Subtitle</label>
      <input type="text" class="form-control" name="subtitle" id="subtitle" value="{{ $subtitle }}" placeholder="Subtitle">
    </div>
</div>

<br>

<div class="form-group">
    <div class="fg-line">
      <label class="fg-label">Page Image <a href="" data-toggle="modal" data-target="#image-help"><i class="zmdi zmdi-help" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Page Image Help"></i></a></label>
      <input type="text" class="form-control" name="page_image" id="page_image" onchange="handle_image_change()" alt="Image thumbnail" value="{{ $page_image }}" placeholder="Example: placeholder.png">
    </div>
</div>

<script type="text/javascript">
  function handle_image_change() {
      $("#page-image-preview").attr("src", function () {
          var value = $("#page_image").val();
          if (!value) {
              value = {!! json_encode(config('blog.page_image')) !!};
              if (value == null) {
                  value = '';
              }
          }
          if (value.substr(0, 4) != 'http' && value.substr(0, 1) != '/') {
              value = {!! json_encode(config('blog.uploads.webpath')) !!} +'/' + value;
          }
          return value;
      });
  }
</script>
<div class="visible-sm space-10"></div>
@if (empty($page_image))
    <span class="text-muted small">No Image Selected</span>
@else
    <img src="{{ page_image($page_image) }}" class="img img_responsive" id="page-image-preview" style="max-height:40px">
@endif

<br>
<br>

<div class="form-group">
    <div class="fg-line">
      <textarea id="editor" name="content" placeholder="Content">{{ $content }}</textarea>
    </div>
</div>

<br>

<div class="form-group">
    <div class="fg-line">
      <label class="fg-label">Publish Date / Time</label>
      <input class="form-control datetime-picker" name="published_at" id="published_at" type="text" value="{{ $published_at }}" placeholder="YYYY/MM/DD HH:MM:SS" data-mask="0000/00/00 00:00:00">
    </div>
</div>
{{ Debugbar::info($allTags) }}
{{ Debugbar::info($tags) }}
<br>
<div class="form-group">
    <div class="fg-line">
      <label class="fg-label">Tags</label>
      <select name="tags[]" id="tags" class="selectpicker" multiple>
          @foreach ($allTags as $tag)
              <option @if (in_array($tag, $tags)) selected @endif value="{{ $tag }}">{{ $tag }}</option>
          @endforeach
      </select>
    </div>
</div>

<br>
{{--<div class="form-group">--}}
    {{--<div class="fg-line">--}}
        {{--<label class="fg-label">Location</label>--}}
        {{--<input type="text" class="form-control" name="location_id" id="layout" value="{{ $location_id }}" placeholder="location_name">--}}
    {{--</div>--}}
{{--</div>--}}

{{ Debugbar::info($locations) }}


{{--<div class="form-group">--}}
    {{--<div class="fg-line">--}}
    {{--{!!  Form::label('fg-label', 'Location') !!}--}}
    {{--</div>--}}

    {{--{!!  Form::select('location_id[]',$locations,$location_id,['id'=>'location_name','class'=>'form-control']) !!}--}}
{{--</div>--}}

<div class="form-group">
    <div class="fg-line">
        <label class="fg-label">Location</label>
        <select  class="form-control" name="location_id[]" id="location_id">
            @foreach($locations as $key =>$value )
            {
                 <option value ="{{$key}}">{{$value}}</option>
            }
            @endforeach
        </select>
    </div>
</div>

<br>
<div class="form-group">
    <div class="fg-line">
      <label class="fg-label">Layout</label>
      <input type="text" class="form-control" name="layout" id="layout" value="{{ $layout }}" placeholder="Layout">
    </div>
</div>

<br>

<div class="form-group">
    <div class="fg-line">
        <label class="fg-label">Meta description</label>
        <textarea class="form-control auto-size" name="meta_description" id="meta_description" style="resize: vertical" placeholder="Meta Description">{{ $meta_description }}</textarea>
    </div>
</div>
 {{ Debugbar::info(Route::getCurrentRoute()->getPath())}}
<br>

<script >

    $( document ).ready(function() {
        var data = [{ id: 0, text: 'enhancement' }, { id: 1, text: 'bug' }, { id: 2, text: 'duplicate' }, { id: 3, text: 'invalid' }, { id: 4, text: 'wontfix' }];

        $('#location_id').select2({
            placeholder: "Select a state"
          // data:data
        });


        //for edit page purpose to allow
       <?php  if(Route::getCurrentRoute()->getPath()=='admin/post/{post}/edit')
              {?>
               $("#location_id").select2().select2('val','<?php echo json_encode($location_id) ?>');
              <?php
              }
         ?>
    });
</script>
