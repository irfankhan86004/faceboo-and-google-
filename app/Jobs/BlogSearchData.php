<?php

namespace App\Jobs;
use Carbon\Carbon;
use App\Models\Tag;
use App\Models\Post;
use App\Models\Settings;
use Illuminate\Queue\SerializesModels;
use Debugbar;
/**
 * Class BlogIndexData.
 */
class BlogSearchData
{
    use SerializesModels;
    protected $tag;
    /**
     * Constructor.
     *
     * @param string|null $tag
     */
    public function __construct($tag,$choose_location)
    {
        $this->tag = $tag;
        $this->location=$choose_location;
    }
    /**
     * Execute the command.
     *
     * @return array
     */
    public function handle()
    {
       // Debugbar::info($this->tag);
       // Debugbar::info($this->location);
        //ONLY location
        if ($this->tag == 0 and isset($this->location))
        {
            //   dd('location');
            return $this->SearchLocationData($this->location);
        }
        //ONLY category
        else if ($this->tag and $this->location ==10000)
        {
            return $this->SearchCategoryData($this->tag);
        }

        // Location and category
        if($this->tag !=0 and $this->location !=10000 and isset($this->location))
        {
//            dd($this->tag);
            return $this->SearchLocationandCateData($this->tag,$this->location);
        }


        return $this->normalIndexData();
    }

    /**
     * Return data for a tag index page.
     *
     * @param string $tag
     * @return array
     */
    protected function tagIndexData($tag,$location)
    {
        $tag = Tag::where('id', $tag)->firstOrFail();

        $reverse_direction = (bool) $tag->reverse_direction;

        $posts = Post::where('published_at', '<=', Carbon::now())
            ->whereHas('tags', function ($q) use ($tag) {
                $q->where('id', '=', $tag->tag);
            })
            ->where('location_id',$location)
            ->where('is_draft', 0)
            ->orderBy('published_at', $reverse_direction ? 'asc' : 'desc')
            ->simplePaginate(config('blog.posts_per_page'));

        $posts->addQuery('tag', $tag->tag);

        $page_image = $tag->page_image ?: config('blog.page_image');

        return [
            'title' => $tag->title,
            'subtitle' => $tag->subtitle,
            'posts' => $posts,
            'page_image' => $page_image,
            'tag' => $tag,
            'reverse_direction' => $reverse_direction,
            'meta_description' => $tag->meta_description ?: \
            Settings::where('setting_name', 'blog_description')->find(1),
        ];
    }

    /**
     * Return data for normal index page.
     *
     * @return array
     */

    protected function SearchLocationData($location)
    {
        if($location==10000)
        {

            $posts = Post::with('tags')
                ->where('published_at', '<=', Carbon::now())
                ->where('is_draft', 0)
                ->orderBy('published_at', 'desc')
                ->simplePaginate(config('blog.posts_per_page'));
        }
        else {
            $posts = Post::with('tags')
                ->where('published_at', '<=', Carbon::now())
                ->where('is_draft', 0)
                ->where('location_id',$location)
                ->orderBy('published_at', 'desc')
                ->simplePaginate(config('blog.posts_per_page'));
        }

        return [
            'title' => Settings::where('setting_name', 'blog_title')->find(1),
            'subtitle' => Settings::where('setting_name', 'blog_subtitle')->find(1),
            'posts' => $posts,
            'page_image' => config('blog.page_image'),
            'meta_description' => Settings::where('setting_name', 'blog_description')->find(1),
            'reverse_direction' => false,
            'tag' => null,
        ];
    }
    protected function SearchCategoryData($category)
    {

        $tag = Tag::where('id', $category)->firstOrFail();
        $posts = Post::with('tags')
            ->where('published_at', '<=', Carbon::now())
            ->whereHas('tags', function ($q) use ($category) {
                $q->where('id', '=',$category);
            })
            ->where('is_draft', 0)
            ->orderBy('published_at', 'desc')
            ->simplePaginate(config('blog.posts_per_page'));

        return [
            'title' => Settings::where('setting_name', 'blog_title')->find(1),
            'subtitle' => Settings::where('setting_name', 'blog_subtitle')->find(1),
            'posts' => $posts,
            'page_image' => config('blog.page_image'),
            'meta_description' => Settings::where('setting_name', 'blog_description')->find(1),
            'reverse_direction' => false,
            'tag' => null,
        ];
    }

    protected function SearchLocationandCateData($category,$location)
    {

        $tag = Tag::where('id', $category)->firstOrFail();
        $posts = Post::with('tags')
            ->where('published_at', '<=', Carbon::now())
            ->whereHas('tags', function ($q) use ($category) {
                $q->where('id', '=',$category);
            })
            ->where('location_id',$location)
            ->where('is_draft', 0)
            ->orderBy('published_at','desc')
            ->simplePaginate(config('blog.posts_per_page'));

        $posts->addQuery('tag', $tag->tag);

        $page_image = $tag->page_image ?: config('blog.page_image');

        return [
            'title' => $tag->title,
            'subtitle' => $tag->subtitle,
            'posts' => $posts,
            'page_image' => $page_image,
            'tag' => $tag,
            'reverse_direction' => false,
            'meta_description' => $tag->meta_description ?: \
            Settings::where('setting_name', 'blog_description')->find(1),
        ];
    }
    protected function normalIndexData()
    {
        $posts = Post::with('tags')
            ->where('published_at', '<=', Carbon::now())
            ->where('is_draft', 0)
//            ->where()
            ->orderBy('published_at', 'desc')
            ->simplePaginate(config('blog.posts_per_page'));

        return [
            'title' => Settings::where('setting_name', 'blog_title')->find(1),
            'subtitle' => Settings::where('setting_name', 'blog_subtitle')->find(1),
            'posts' => $posts,
            'page_image' => config('blog.page_image'),
            'meta_description' => Settings::where('setting_name', 'blog_description')->find(1),
            'reverse_direction' => false,
            'tag' => null,
        ];
    }
}
