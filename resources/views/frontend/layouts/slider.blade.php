<div class="container-fluid">
    <section class="main-slider">
        <div class="row align-items-center">
            <div class="col-lg-12 col-md-12">
                <div id="myCarousel" class="carousel slide carousel-fade" data-ride="carousel">
    
        <!-- Carousel items -->
        <div class="carousel-inner">
        @foreach ($slider as $slider)
            <!-- Slide 1 : Active -->
            <div class="item @if ($loop->first) active  @endif ">
                <img src="sliderphoto/{{$slider->image}}" class="img-responsive wow slideInDown" data-wow-duration="2s"
                     alt="">
                <div class="carousel-caption">
                    <h3 class="wow slideInLeft" data-wow-duration="3s">
                        {{$slider->caption_title}}</h3>
                    <p class="wow slideInUp" data-wow-duration="4s">  {{$slider->caption_description}}</p>
    
                </div><!-- /.carousel-caption -->
            </div><!-- /Slide1 -->
        @endforeach
        <!-- Slide 3 -->
        </div><!-- /.carousel-inner -->
    
        <!-- Controls -->
        <div class="control-box">
            <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                <span class="control-icon prev  " aria-hidden="true"><i class="fa fa-angle-double-left"
                                                                        aria-hidden="true"></i></span>
                <span class="sr-only">Previous</span>
            </a>
    
            <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
    
                <span class="control-icon next  " aria-hidden="true"><i class="fa fa-angle-double-right"
                                                                        aria-hidden="true"></i></span>
                <span class="sr-only">Next</span>
            </a>
        </div><!-- /.control-box -->
    </div><!-- /#myCarousel -->
            </div>
        </div>
    </section>
</div>



