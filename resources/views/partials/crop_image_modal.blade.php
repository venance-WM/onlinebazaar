<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Crop Image Before Upload</h5>
                <button type="button" class="close" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="img-container">
                    <div class="row">
                        <div class="col-md-8 col-12">
                            <img src="" id="image_to_crop" />
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="preview"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="crop" class="btn btn-primary">Crop</button>
                <button type="button" class="btn btn-secondary" id="cancelButton">Cancel</button>
            </div>
        </div>
    </div>
</div>

@push('styles')
    {{-- <link rel="stylesheet" href="https://unpkg.com/dropzone/dist/dropzone.css" /> --}}
    <link href="https://unpkg.com/cropperjs/dist/cropper.css" rel="stylesheet" />
    {{-- <script src="https://unpkg.com/dropzone"></script> --}}
    <script src="https://unpkg.com/cropperjs"></script>
    <style>
        img {
            display: block;
            max-width: 100%;
        }

        .preview {
            overflow: hidden;
            width: 160px;
            height: 160px;
            margin: 10px;
            border: 1px solid red;
        }

        .modal-md {
            max-width: 800px !important;
        }

        #image_to_crop {
            max-width: 100%;
            max-height: 80vh;
            object-fit: contain;
        }
    </style>
@endpush

@push('script')
    <script>
        $(document).ready(function() {
            let $modal = $('#modal');
            let image = document.getElementById('image_to_crop');
            let cropper;
            let currentCroppedInput; // Variable to keep track of the current hidden input

            // General function to handle file changes
            function handleFileChange(inputSelector, croppedImageInputSelector, aspectRatio) {
                $(inputSelector).change(function(event) {
                    let files = event.target.files;

                    if (files && files.length > 0) {
                        let reader = new FileReader();
                        reader.onload = function() {
                            image.src = reader.result;
                            $(image).data('aspectRatio', aspectRatio);
                            $modal.modal({
                                backdrop: 'static',
                                keyboard: false
                            });
                            $modal.modal('show');

                            // Initialize the cropper
                            if (cropper) {
                                cropper.destroy();
                            }
                            cropper = new Cropper(image, {
                                aspectRatio: aspectRatio,
                                viewMode: 3,
                                preview: '.preview'
                            });

                            // Set the current input
                            currentCroppedInput = croppedImageInputSelector;
                        };
                        reader.readAsDataURL(files[0]);
                    }
                });
            }

            // On crop button click
            $('#crop').on('click', function() {
                if (cropper) {
                    let canvas = cropper.getCroppedCanvas({
                        width: 400,
                        height: 400
                    });

                    canvas.toBlob(function(blob) {
                        let reader = new FileReader();
                        reader.readAsDataURL(blob);
                        reader.onloadend = function() {
                            let base64data = reader.result;

                            // Set the base64 image data to the current hidden input field
                            $(currentCroppedInput).val(base64data);
                            $modal.modal('hide');
                        };
                    });
                }
            });

            // Close modal and destroy cropper on close
            $modal.on('hidden.bs.modal', function() {
                if (cropper) {
                    cropper.destroy();
                    cropper = null;
                }
                currentCroppedInput = null; // Reset the current input tracker
            });

            $('#modal .close, #cancelButton').on('click', function() {
                $modal.modal('hide');
            });

            // Apply the function for different image inputs
            handleFileChange('#fileUpload', '#croppedImage', 1);
            handleFileChange('#coverImageOne', '#croppedCoverImageOne', 16 / 9);
            handleFileChange('#coverImageTwo', '#croppedCoverImageTwo', 16 / 9);
            handleFileChange('#coverImageThree', '#croppedCoverImageThree', 16 / 9);
            // handleFileChange('#productImage', '#productCroppedImage', 1);
        });
    </script>
@endpush
