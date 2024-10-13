@push('script')
    <script>
        $(document).ready(function() {
            // Fetch regions on page load
            $.get('/regions', function(data) {
                $('#region').append('<option value="" hidden>Select Region</option>');
                $.each(data, function(index, region) {
                    $('#region').append('<option value="' + region.id + '">' + region.name +
                        '</option>');
                });
            });

            // Fetch districts when a region is selected
            $('#region').change(function() {
                var regionId = $(this).val();
                $('#district').empty().append('<option value="" hidden>Select District</option>');
                $('#ward').empty().append('<option value="" hidden>Select Ward</option>');

                if (regionId) {
                    $.get('/districts/' + regionId, function(data) {
                        $.each(data, function(index, district) {
                            $('#district').append('<option value="' + district.id + '">' +
                                district.name + '</option>');
                        });
                    });
                }
            });

            // Fetch wards when a district is selected
            $('#district').change(function() {
                var districtId = $(this).val();
                $('#ward').empty().append('<option value="" hidden>Select Ward</option>');

                if (districtId) {
                    $.get('/wards/' + districtId, function(data) {
                        $.each(data, function(index, ward) {
                            $('#ward').append('<option value="' + ward.id + '">' + ward
                                .name + '</option>');
                        });
                    });
                }
            });

            // Fetch streets when a ward is selected
            $('#ward').change(function() {
                var wardId = $(this).val();
                $('#street').empty().append('<option value="" hidden>Select Street</option>');

                if (wardId) {
                    $.get('/streets/' + wardId, function(data) {
                        $.each(data, function(index, street) {
                            $('#street').append('<option value="' + street.id + '">' +
                                street
                                .name + '</option>');
                        });
                    });
                }
            });
        });
    </script>
@endpush
