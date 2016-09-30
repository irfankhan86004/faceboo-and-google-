
<div class="search">
    <div class="row">
        <div class="form-gorup col-lg-6">
            <label for="type">Location:</label>
            <select id="type"  class="form-control">
                <option value="">Any</option>
                <option value="global">Remote / Anywhere</option>
                <option value="usa">Remote / US</option>
                <option value="no">Local</option>
            </select>
        </div>
        {{--{{ Debugbar::info($alltags)}}--}}
        <div class="form-gorup col-lg-6">
            <label for="type">Category:</label>
            <select id="type"  class="form-control">
                <option value="0">Any</option>
                @foreach ($alltags as $tags)
                    <option value="{{$tags->id}}">{{$tags->tag}}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
