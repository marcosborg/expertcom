<!-- ======= Hero Section ======= -->
<section id="hero" style="background-image: url('')">
    <div class="hero-container" data-aos="fade-up" data-aos-delay="150">
        <h1>{{ $hero->title }}</h1>
        <h2>{{ $hero->subtitle }}</h2>
        <div class="d-flex">
            <a href="{{ $hero->link }}" class="btn-get-started scrollto">{{ $hero->button }}</a>
        </div>
    </div>
</section><!-- End Hero -->