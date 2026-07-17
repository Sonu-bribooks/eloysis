<section id="about" class="about-section py-5">

    <div class="container">

        <div class="row align-items-center">

            <div class="col-lg-6 mb-4 mb-lg-0">

                <img
                    src="{{$pageData['about']['image'] }}"
                    alt="About Us"
                    class="img-fluid rounded shadow">

            </div>

            <div class="col-lg-6">

                <span class="about-subtitle">
                    {{ $pageData['about']['subtitle'] }}
                </span>

                <h2 class="about-title mt-2">
                    {{ $pageData['about']['title'] }}
                </h2>

                <p class="about-description mt-4">
                    {{ $pageData['about']['description'] }}
                </p>

                <a href="{{ $pageData['about']['button_url'] }}"
                    class="btn btn-primary mt-3">

                    {{ $pageData['about']['button_text'] }}

                </a>

            </div>

        </div>

    </div>

</section>