<?php namespace VnsModules\Slide;

use Repositories\Term\TermRepository;

class SlideRepository extends TermRepository implements SlideRepositoryInterface
{
    public function getModel()
    {
        return Slide::class;
    }
}