<div class="bg-white rounded-top shadow-sm mb-3">
    <div class="row g-0">
        <div class="col col-lg-7 mt-6 p-4">

            <h2 class="mt-2 text-dark fw-light">
                {{__('welcome_title')}}
            </h2>
            <p>
                {{__('welcome_subtitle')}}
            </p>
        </div>
        <div class="d-none d-lg-block col align-self-center text-end text-muted p-4">
            {{-- <x-orchid-icon path="orchid" width="6em" height="100%"/> --}}
        </div>
    </div>

    <div class="row bg-light m-0 p-4 border-top rounded-bottom">

        <div class="col-md-6 my-2">
            <h3 class="text-muted fw-light">
                <x-orchid-icon path="book-open"/>

                <span class="ms-3 text-dark">Découvrez la Qualité au CFA</span>
            </h3>
            <p class="ms-md-5 ps-md-1">
                {{__('go_to_wealth')}}
            </p>
        </div>

         <div class="col-md-6 my-2">
            <h3 class="text-muted fw-light">
                <x-orchid-icon path="tag"/>

                <span class="ms-3 text-dark">
                    <a href="{{route('platform.quality.wealths')}}" >
                        {{__("welcome_wealths_title")}}
                    </a>
                </span>
            </h3>
            <p class="ms-md-5 ps-md-1">

            </p>
        </div>

        <div class="col-md-6 my-2">
            <h3 class="text-muted fw-light">
                <x-orchid-icon path="tag"/>

                <span class="ms-3 text-dark">
                    <a href="{{route('platform.quality.tags')}}" >
                        {{__("welcome_labels_title")}}
                    </a>
                </span>
            </h3>
            <p class="ms-md-5 ps-md-1">

            </p>
        </div>

        <div class="col-md-6 my-2">
            <h3 class="text-muted fw-light">
                <x-orchid-icon path="layers"/>

                <span class="ms-3 text-dark">
                    <a href="{{route('platform.quality.actions')}}" >
                        {{__("welcome_actions_title")}}
                    </a> 
                </span>
            </h3>
            <p class="ms-md-5 ps-md-1">
            </p>
        </div>
    </div>

</div>