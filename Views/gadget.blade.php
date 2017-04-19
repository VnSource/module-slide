<div id="myCarousel" class="carousel slide">
  <div class="carousel-inner">
    @foreach ($slides as $index => $silde)
    <a href="{{$silde->slug}}" class="item{{($index==0)?' active':''}}">
      <img src="{{ $silde->image }}" alt="{{ $silde->name }}"/>
      <div class="carousel-caption">{!! $silde->description !!}</div>
    </a>
    @endforeach
  </div>
    <ol class="carousel-indicators">
      @foreach ($slides as $index => $silde)
      <li data-target="#myCarousel" data-slide-to="{{$index}}"{!!($index==0)?' class="active"':''!!}></li>
      @endforeach
    </ol>
    <a class="left carousel-control" href="#myCarousel"  data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
    <a class="right carousel-control" href="#myCarousel" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
</div>
@push('head')
  <style media="screen">
    #myCarousel .carousel-inner img {
      width: 100%;
      max-width: inherit;
    }
    #myCarousel .carousel-caption {
      right: inherit;
      bottom: inherit;
      top: 20%;
      left: 15%;
      text-align: left;
      max-width: 620px;
      padding-top: 0;
    }
    #myCarousel .carousel-caption p {
      font-size: 18px;
      margin-bottom: 0;
    }
    #myCarousel .carousel-caption h3 {
      font-size: 50px;
      margin: 0;
      text-transform: capitalize;
      margin-bottom: 10px;
    }
    @media screen and (max-width: 767px) {
      #myCarousel .carousel-caption {
        top: 10%;
        right: 15%;
      }
      #myCarousel .carousel-caption p {
        font-size: 15px;
      }
      #myCarousel .carousel-caption h3 {
        font-size: 36px;
      }
    }
    @media screen and (max-width: 450px) {
      #myCarousel .carousel-caption {
        top: 10px;
        right: 10%;
        left: 10%;
      }
      #myCarousel .carousel-caption p {
        font-size: 14px;
      }
      #myCarousel .carousel-caption h3 {
        font-size: 24px;
        margin-bottom: 0;
      }
    }
  </style>
@endpush
@push('script')
    <script type="text/javascript">
    $(function(){
        $('#myCarousel').carousel({interval:6000})
    });
    </script>
@endpush
