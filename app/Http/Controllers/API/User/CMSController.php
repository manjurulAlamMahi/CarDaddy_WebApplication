<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use App\Models\Blog;
use App\Models\DynamicPage;
use App\Models\FAQ;
use App\Models\SystemSetting;
use App\Models\Testimonial;
use App\Traits\apiresponse;
use Illuminate\Http\Request;

class CMSController extends Controller
{
    use apiresponse;
    public function aboutus(Request $request)
    {
        $query = AboutUs::query();

        $data = $query->first();

        return $this->success($data, 'Successfully!', 200);
    }
    public function blogs(Request $request)
    {
        $query = Blog::query();

        $query->where('status', 'active');

        if ($request->has('date')) {
            $query->where('date', $request->date);
        }

        $data = $query->get();

        return $this->success($data, 'Successfully!', 200);
    }
    public function testmonial(Request $request)
    {
        $query = Testimonial::query();

        $query->where('status', 'active');


        $data = $query->get();

        return $this->success($data, 'Successfully!', 200);
    }
    public function faqs(Request $request)
    {
        $query = FAQ::query();

        $query->where('status', 'active');


        $data = $query->get();

        return $this->success($data, 'Successfully!', 200);
    }
    public function signleblogs($slug)
    {
        $query = Blog::query();

        $query->where('slug', $slug);

        $data = $query->first();

        return $this->success($data, 'Successfully!', 200);
    }
    public function dynamicPage($page_slug)
    {
        $query = DynamicPage::query();

        $query->where('page_slug', $page_slug);

        $data = $query->first();

        return $this->success($data, 'Successfully!', 200);
    }
    public function site()
    {
        $query = SystemSetting::query();

        $data = $query->first();

        return $this->success($data, 'Successfully!', 200);
    }
}
