<aside id="sidebar" class="sidebar c-overflow">
    <div class="profile-menu">
        <a href="">
            <div class="profile-pic">
                <img src="//www.gravatar.com/avatar/{{ md5(Auth::user()->email) }}?d=identicon">
            </div>
            <div class="profile-info">
                {{ Auth::user()->display_name }}
                {{$user_level}}
                {{ Auth::user()->id }}
                <i class="zmdi zmdi-caret-down"></i>
            </div>
        </a>
        <ul class="main-menu profile-ul">
            <li @if (Request::is('admin/profile')) class="active" @endif><a href="{{ url('admin/profile') }}"><i class="zmdi zmdi-account"></i> Profile</a></li>
            <li @if (Request::is('admin/profile/*')) class="active" @endif><a href="{{ route('admin.profile.edit', Auth::id()) }}"><i class="zmdi zmdi-edit"></i> Edit Profile</a></li>
            <li><a href="{{ url('auth/logout') }}" name="logout"><i class="zmdi zmdi-power"></i> Sign out</a></li>
        </ul>
    </div>
    <ul class="main-menu main-ul">
        <li @if (Request::is('admin')) class="active" @endif><a href="{{ url('admin') }}"><i class="zmdi zmdi-home"></i> Home</a></li>
        <li @if (Request::is('admin/post*')) class="active" @endif><a href="{{ url('admin/post') }}"><i class="zmdi zmdi-collection-bookmark"></i> Posts <span class="label label-default label-totals">

        {{ App\Models\Post::where('user_id',Auth::user()->id)->count() }}

         <!-- {{ App\Models\Post::count() }} -->
        </span>
        </a></li>
        <li @if (Request::is('admin/tag*')) class="active" @endif><a href="{{ url('admin/tag') }}"><i class="zmdi zmdi-labels"></i> Tags <span class="label label-default label-totals">{{ App\Models\Tag::count() }}</span></a></li>
        <li @if (Request::is('admin/upload*')) class="active" @endif><a href="{{ url('admin/upload') }}"><i class="zmdi zmdi-collection-folder-image"></i> Media</a></li>
       <li @if (Request::is('admin/profile')) class="active" @endif><a href="{{ url('admin/profile') }}"><i class="zmdi zmdi-account"></i> Profile</a></li>
       <li @if (Request::is('admin/profile/*')) class="active" @endif><a href="{{ route('admin.profile.edit', Auth::id()) }}"><i class="zmdi zmdi-edit"></i> Edit Profile</a></li>
       <li><a href="{{ url('auth/logout') }}" name="logout"><i class="zmdi zmdi-power"></i> Sign out</a></li>
    </ul>

</aside>
