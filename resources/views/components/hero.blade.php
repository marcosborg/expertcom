<!-- ======= Hero Section ======= -->
<section id="hero" style="background-image: url('')">
    <div class="hero-container" data-aos="fade-up" data-aos-delay="150">
        <h1>Login</h1>
        <h2>backoffice</h2>
        <div class="d-flex">
            @auth
            <a href="/admin" class="btn-get-started scrollto">Dashboard</a>
            @else
            <a href="/login" class="btn-get-started scrollto">Login</a>
            @endauth
            
        </div>
    </div>
</section><!-- End Hero -->