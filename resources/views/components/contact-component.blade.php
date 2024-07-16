<!-- ======= Contact Section ======= -->
<section id="contact" class="contact">
    <div class="container" data-aos="fade-up"">

        <div class=" section-title">
        <h2>Contactos</h2>
        <p>Entre em contacto connosco</p>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="info-box">
                <i class="bx bx-map"></i>
                <h3>Departamento Admnistrativo</h3>
                <p>Rua Faria Guimarães 654 4200-201, Porto</p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="info-box">
                <i class="bx bx-map"></i>
                <h3>Departamento Operacional</h3>
                <p>Rua Godinho Faria 468 4465-150 São Mamede Infesta</p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="info-box mt-4">
                <i class="bx bx-envelope"></i>
                <h3>Email</h3>
                <p>info@expertcom.pt </p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="info-box mt-4">
                <i class="bx bx-phone-call"></i>
                <h3>Ligue</h3>
                <p>+351 915 422 233</p>
            </div>
        </div>
    </div>
    @if(session('message'))
    <div class="row" style='padding:20px 20px 0 20px;'>
        <div class="col-lg-12">
            <div class="alert alert-success" role="alert">{{ session('message') }}</div>
        </div>
    </div>
    @endif
    @if($errors->count() > 0)
    <div class="row" style='padding:20px 20px 0 20px;'>
        <div class="col-lg-12">
            <div class="alert alert-danger">
                <ul class="list-unstyled">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif
    <div class="row">
        @foreach ($forms as $form)
        <div class="col-6">
            <form action="/form-data" method="post" role="form" class="php-email-form">
                <input type="hidden" name="form_name_id" value="{{ $form->id }}">
                @csrf
                <div class="mb-4">
                    <h4>{{ $form->name }}</h4>
                    <strong>{{ $form->description }}</strong>
                </div>
                @foreach ($form->form_inputs as $form_input)
                <div class="form-group m-2">
                    <input type="text" name="{{ $form_input->name }}" class="form-control"
                        id="{{ $form_input->name }}" placeholder="{{ $form_input->label }}" {{ $form_input->required ?
                    'required' : '' }}>
                </div>
                @endforeach
                <div class="text-center mt-5"><button type="submit">Enviar</button></div>
            </form>
        </div>
        @endforeach
    </div>
</section><!-- End Contact Section -->