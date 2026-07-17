<section class="quick-links">

    <div class="container">

        <div class="row">

            @foreach($pageData['quick_links'] as $item)

            <div class="col-lg-4 mb-4">

                <div class="quick-card border-{{ $item['color'] }}">

                    <i class="{{ $item['icon'] }}"></i>

                    <h4>

                        {{ $item['title'] }}

                    </h4>

                    <p>

                        {{ $item['description'] }}

                    </p>

                    <a href="{{ $item['url'] }}">

                        Read More →

                    </a>

                </div>

            </div>

            @endforeach

        </div>

    </div>

</section>