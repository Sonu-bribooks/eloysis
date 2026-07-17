<section id="home" class="hero-section">

    <div id="heroSlider" class="carousel slide carousel-fade" data-bs-ride="carousel">

        <div class="carousel-inner">

            @foreach ($pageData['sliders'] as $slider)

            <div class="carousel-item @if($loop->first) active @endif">

                <div class="hero-slide">

                    <img
                        src="{{ $slider['image'] }}"
                        class="d-block w-100 hero-image"
                        alt="{{ $slider['title'] }}">

                    <div class="hero-overlay"></div>

                    <div class="container">

                        <div class="hero-content">

                            <h1>{{ $slider['title'] }}</h1>

                            <p>{{ $slider['subtitle'] }}</p>

                            <a href="{{ $slider['button_url'] }}"
                                class="btn btn-primary btn-lg">

                                {{ $slider['button_text'] }}

                            </a>

                        </div>

                    </div>

                </div>

            </div>

            @endforeach

        </div>

        <button class="carousel-control-prev"
            type="button"
            data-bs-target="#heroSlider"
            data-bs-slide="prev">

            <span class="carousel-control-prev-icon"></span>

        </button>

        <button class="carousel-control-next"
            type="button"
            data-bs-target="#heroSlider"
            data-bs-slide="next">

            <span class="carousel-control-next-icon"></span>

        </button>

    </div>

</section>