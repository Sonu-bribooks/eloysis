<section class="statistics-section py-5">

    <div class="container">

        <div class="row">

            @foreach($pageData['statistics'] as $item)

            <div class="col-lg-3 col-md-6 mb-4">

                <div class="statistics-card">

                    <div class="statistics-icon">
                        <i class="{{ $item['icon'] }}"></i>
                    </div>

                    <h2>{{ $item['count'] }}</h2>

                    <p>{{ $item['title'] }}</p>

                </div>

            </div>

            @endforeach

        </div>

    </div>

</section>