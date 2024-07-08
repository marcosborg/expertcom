<!-- ======= About Boxes Section ======= -->
<section id="about-boxes" class="about-boxes">
    <div class="container" data-aos="fade-up">

        <div class="row">
            @foreach ($activities as $item)
            <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100">
                <div class="card">
                    <img src="{{ $item->image->getUrl() }}" class="card-img-top" alt="...">
                    <div class="card-icon">
                        <i class="ri-brush-4-line"></i>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title"><a href="{{ $item->link }}">{{ $item->title }}</a></h5>
                        <p class="card-text">{{ $item->description }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</section><!-- End About Boxes Section -->
<script>console.log({!! $activities !!})</script>