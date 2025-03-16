<!-- Modal HTML - Note: unique ID per promotion -->
<div class="modal fade" id="imageGalleryModal-{{ $promotion->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div id="galleryCarousel-{{ $promotion->id }}" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">

                        @foreach ($allImages as $index => $image)
                            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                <img src="{{ file_exists(public_path('uploads/promotions/' . $image)) ? asset('uploads/promotions/' . $image) : asset('uploads/default.png') }}"
                                    class="d-block w-100" style="object-fit: contain; max-height: 500px;"
                                    alt="Promotion Image">
                            </div>
                        @endforeach

                    </div>
                    <a class="carousel-control-prev" href="#galleryCarousel-{{ $promotion->id }}" role="button"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#galleryCarousel-{{ $promotion->id }}" role="button"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
