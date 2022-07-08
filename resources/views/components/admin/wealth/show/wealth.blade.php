<div class="row bg-light m-0 p-4 border-top rounded-bottom">
    <div class="col-md-8 my-2">
        <div class="d-flex flex-wrap">
            <h3 class="mb-3 text-muted fw-light">
                @if ($wealth->wealthType->name === 'file')
                    <x-orchid-icon path="book-open" />
                @endif
                @if ($wealth->wealthType->name === 'link')
                    <x-orchid-icon path="link" />
                @endif
                @if ($wealth->wealthType->name === 'ypareo')
                    <x-orchid-icon path="task" />
                @endif

                <span class="ms-3 text-dark">{{ $wealth->name }}</span>

                <div class="progress conformity-level-bg-progress_bar">
                    <div class="progress-bar conformity-level-badge-{{ $wealth->conformity_level }}" role="progressbar"
                        style="width: {{ $wealth->conformity_level }}%"
                        aria-valuenow="{{ $wealth->conformity_level }}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </h3>
            <div class="ps-4 pb-3 d-flex flex-wrap">
                @foreach ($wealth->tags as $tag)
                    <span class="ms-md-2">
                        <x-orchid-icon path="tag" />
                        {{ $tag->name }}
                    </span>
                @endforeach
            </div>
        </div>
        <p class="ms-md-2 ps-md-1">
            {!! $wealth->description !!}
        </p>
    </div>
    <div class="col-md-6 my-2">
        <h4 class="text-muted fw-light">
            <x-orchid-icon path="module" />
            <span class="ms-3 text-grey">{{ __('result_set_attachment_info') }}</span>
        </h4>
        <p class="ms-md-5 ps-md-1">
            @if ($wealth->wealthType->name === 'file')
                @if (count($wealth->files) > 0)
                    @foreach ($wealth->files as $file)
                        <span>
                            Voir le fichier
                            <a href='{{ $file->gdrive_shared_link }}' target="_blank"
                                class="text-u-l">{{ $file->original_name }}</a>
                        </span>
                    @endforeach
                @endif
            @endif
            @if ($wealth->wealthType->name === 'link')
                <span>
                    les éléments de preuve sont accessible sur la page
                    {{ $wealth->attachment['link']['type'] }}
                    <a href="https://laravel.com/docs" target="_blank"
                        class="text-u-l">{{ $wealth->attachment['link']['url'] }}</a>
                </span>
            @endif
            @if ($wealth->wealthType->name === 'ypareo')
                <span>
                    Le process ypareo est le suivant: <br>
                    {!! $wealth->attachment['ypareo']['process'] !!}
                </span>
            @endif
        </p>
    </div>

    <div class="col-md-6 my-2">
        <h4 class="text-muted fw-light">
            <x-orchid-icon path="people" />
            <span class="ms-3 text-grey">{{ __('result_set_processus_title') }}</span>
        </h4>
        <p class="ms-md-5 ps-md-1">
            {{ $wealth->processus->label }}
        </p>
    </div>


    @if ($wealth->indicators)
        <div class="col-md-8 my-2">
            <h4 class="text-muted fw-light">
                <x-orchid-icon path="equalizer" />
                <span class="ms-3 text-grey">{{ __('result_set_indicators_title') }}</span>
            </h4>
            @foreach ($wealth->indicators as $indicator)
                <div class="d-flex ps-5 border-top justify-content-evenly">
                    <span class="d-flex">
                        <h5 class="text-muted fw-light">
                            <x-orchid-icon path="building" />
                            <span class="ms-1 text-grey">{{ $indicator->qualityLabel->label }}</span>
                        </h5>
                        <!-- <span class="ps-3 text-black">{{ $indicator->qualityLabel->label }}</span> -->

                    </span>
                    <span class="d-flex">
                        <h5 class="text-muted fw-light">
                            <x-orchid-icon path="compass" />
                            <span
                                class="ms-md-1 text-grey">{{ $indicator->criteria_number . '-' . $indicator->indicater_number . ' : ' . $indicator->label }}</span>
                        </h5>
                        <!-- <span class="ms-1 text-black">{{ $indicator->criteria_number . '-' . $indicator->indicater_number . ' : ' . $indicator->label }}</span> -->
                    </span>

                </div>
            @endforeach
        </div>
    @endif
    @if ($wealth->actions)
        <div class="col-md-8 my-2">
            <h4 class="text-muted fw-light">
                <x-orchid-icon path="graduation" />
                <span class="ms-3 text-grey">{{ __('result_set_actions_title') }}</span>
            </h4>
            @foreach ($wealth->actions as $action)
                <div class="d-flex ps-5 border-top justify-content-evenly">
                    <span class="d-flex">
                        <h5 class="text-muted fw-light">
                            <x-orchid-icon path="briefcase" />
                            <span class="ms-1 text-grey">{{ $action->label }}</span>
                        </h5>
                        <!-- <span class="ps-3 text-black">{{ $action->stage->label }}</span> -->

                    </span>
                    <span class="d-flex">
                        <h5 class="text-muted fw-light">
                            <x-orchid-icon path="directions" />
                            <span class="ms-md-1 text-grey">{{ $action->stage->label }}</span>
                        </h5>
                    </span>

                </div>
            @endforeach
        </div>
    @endif

</div>
