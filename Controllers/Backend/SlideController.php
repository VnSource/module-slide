<?php namespace VnsModules\Slide\Controllers\Backend;

use Illuminate\Http\Request;
use VnsModules\Slide\SlideRequest;
use VnsModules\Slide\SlideRepositoryInterface as SlideRepository;

class SlideController extends \App\Http\Controllers\Controller
{
    protected $slides;

    public function __construct(SlideRepository $slides)
    {
        $this->slides = $slides;
    }
    public function index()
    {
        $slides = $this->slides->getAllOrder();
        return response()->json($slides);
    }

    public function show($id)
    {
        $slide = $this->slides->find($id);
        return response()->json($slide);
    }

    public function store(SlideRequest $request)
    {
        $input = $request->all();
        $input['order'] = $this->slides->getCount() + 1;
        $slide = $this->slides->create($input);
        return response()->json($slide);
    }

    public function update(SlideRequest $request, $id)
    {
        $slide = $this->slides->update($id, $request->all());
        return response()->json($slide);
    }

    public function destroy($id)
    {
        $slide = $this->slides->delete($id);
        return response()->json($slide);
    }

    public function sortSlide(Request $request) {
        $slides = $request->input('data');
        foreach ($slides as $key => $id) {
            $this->slides->update($id, ['order' => $key+1]);
        }
        return response()->json(['success' => true]);
    }
}
