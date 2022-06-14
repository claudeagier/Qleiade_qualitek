<!-- <div class="bg-light p-5 rounded">
    <x-orchid-icon path="cloud-upload" class="h3"/>
    <h1 class="text-muted w-b-k d-block">{{__('Add file')}}</h1>
    <div class="form-group mt-4">
        <input type="file" name="file" class="form-control" accept=".jpg,.jpeg,.bmp,.png,.gif,.doc,.docx,.csv,.rtf,.xlsx,.xls,.txt,.pdf,.zip">
    </div>
</div> -->

<div id="dropzone-{{$id}}" class="dropzone-wrapper">
    <div class="fallback">
        <input type="file" value="" multiple/>
    </div>
    <div class="visual-dropzone sortable-dropzone dropzone-previews">
        <div class="dz-message dz-preview dz-processing dz-image-preview">
            <div class="bg-light d-flex justify-content-center align-items-center border r-2x"
                style="min-height: 112px;">
                <div class="pe-1 ps-1 pt-3 pb-3">
                    <x-orchid-icon path="cloud-upload" class="h3"/>
                    <small class="text-muted w-b-k d-block">{{__('Upload file')}}</small>
                </div>
            </div>
        </div>
    </div>

    <div class="attachment modal fade center-scale" tabindex="-1" role="dialog" aria-hidden="false">
        <div class="modal-dialog modal-fullscreen-md-down">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-black fw-light">
                        {{__('File Information')}}
                        <small class="text-muted d-block">{{__('Information to display')}}</small>
                    </h4>

                    <button type="button" class="btn-close" title="Close" data-bs-dismiss="modal"
                            aria-label="Close">
                    </button>
                </div>
                <div class="modal-body p-4">
                    <div class="form-group">
                        <label>{{__('System name')}}</label>
                        <input type="text" class="form-control" data-target="upload.name" readonly
                            maxlength="255">
                    </div>
                    <div class="form-group">
                        <label>{{ __('Display name') }}</label>
                        <input type="text" class="form-control" data-target="upload.original"
                            maxlength="255" placeholder="{{ __('Display name') }}">
                    </div>
                    <div class="form-group">
                        <label>{{ __('Alternative text') }}</label>
                        <input type="text" class="form-control" data-target="upload.alt"
                            maxlength="255" placeholder="{{  __('Alternative text')  }}">
                    </div>
                    <div class="form-group">
                        <label>{{ __('Description') }}</label>
                        <textarea class="form-control no-resize"
                                data-target="upload.description"
                                placeholder="{{ __('Description') }}"
                                maxlength="255"
                                rows="3"></textarea>
                    </div>


                    @if($attachment_visibity === 'public')
                        <div class="form-group">
                            <a href="#" data-action="click->upload#openLink">
                                <small>
                                    <x-orchid-icon path="link" class="me-2"/>

                                    {{ __('Link to file') }}
                                </small>
                            </a>
                        </div>
                    @endif


                </div>
                <div class="modal-footer">
                    <button type="button"
                            data-bs-dismiss="modal"
                            class="btn btn-link">
                            <span>
                                {{__('Close')}}
                            </span>
                    </button>
                    <button type="button" data-action="click->upload#save" class="btn btn-default">
                        {{__('Apply')}}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <template id="dropzone-{{$id}}-remove-button">
        <a href="javascript:;" class="btn-remove">&times;</a>
    </template>

    <template id="dropzone-{{$id}}-edit-button">
        <a href="javascript:;" class="btn-edit">
            <x-orchid-icon path="note" class="mb-1"/>
        </a>
    </template>
</div>
</div>