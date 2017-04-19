<?php namespace VnsModules\Slide;

class Gadget
{
    public function register() {
        $datas = [
          'slides' => \Cache::remember('VnsModuleSlideGadget', cache_time(), function () {
            return Slide::where('status', true)
                ->byOrder()
                ->get()
            ;
          })
        ];
        return view('VnsModules\Slide::gadget', $datas);
    }
}
