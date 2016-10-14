
<div class="search">
    <div class="row">
        <form id ="searchform" role="form" method="POST" action="{{ route('home.search') }}" >
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-gorup col-lg-6">
                <label for="type">Location:</label>
                <select name = "select_location" id="front_location_select"  class="form-control">
                    <option value="10000"  @if(isset($_REQUEST['select_location'])){
                            @if($_REQUEST['select_location']==100){
                            selected
                            }@endif
                            }
                            @endif>Any
                    </option>
                    @foreach ($alllocations as $locations)
                     <option value="{{$locations->id}}"
                                @if(isset($_REQUEST['select_location'])){
                                    @if($locations->id == $_REQUEST['select_location']){
                                    selected
                                    }@endif
                                }@endif>
                    {{$locations->location_name}}
                     </option>
                    @endforeach
                </select>
                {{--{{Debugbar::info($_REQUEST['select_category'])}}--}}
                {{--{{Debugbar::info($_REQUEST['select_location'])}}--}}

            </div>
            {{--{{ Debugbar::info($alllocations)}}--}}
            {{--{{ Debugbar::info($alltags)}}--}}
            <div class="form-gorup col-lg-6">
                <label for="type">Category:</label>
                <select  name ="select_category" id="category_select"  class="form-control">
                    <option value="0"  @if(isset($_REQUEST['select_category'])){
                            @if($_REQUEST['select_category']==0){
                            selected
                            }@endif
                            }
                            @endif>Any
                    </option>
                    @foreach ($alltags as $tags)
                        <option value="{{$tags->id}}"
                                @if(isset($_REQUEST['select_category'])){
                                @if($tags->id == $_REQUEST['select_category']){
                                selected
                                }@endif
                                }@endif >{{$tags->tag}}</option>
                    @endforeach
                </select>
            </div>
            {{--<div class="form-gorup col-lg-2">--}}
                {{--<button type="submit" class="btn btn-default">Submit</button>--}}
            {{--</div>--}}

        </form>
    </div>

</div>
<script >
    $( document ).ready(function() {
        $('#front_location_select').select2({
            placeholder: "Select a City"
        });
        $('#category_select').select2({
            placeholder: "Select a category"
        });
        $('#front_location_select, #category_select').change(function()
        {
            $('#searchform').submit();
        });
});
</script>