$(function () {
    const APP_URL = window.location.origin;
    const  stateSelector = $('#states');
    const  countrySelector =  $('#countries');
    const  citySelector =  $('#cities');

    $('.role').select2();
    countrySelector.select2();
    citySelector.select2();
    stateSelector.select2();

    $('#textUrl').on('keyup', function () {
        var pretty_url = slugify($(this).val());
        $('#url').html(slugify(pretty_url));
        $('#slug').val(pretty_url);
    });

    $('#thumbnail').on('change', function () {
        var file = $(this).get(0).files;
        var reader = new FileReader();
        reader.readAsDataURL(file[0]);
        reader.addEventListener("load", function (e) {
            var image = e.target.result;
            $('#show-thumbnail').attr('src', image);
        })
    });

    // On Country Change
    countrySelector.on('change', function () {
        const  id = $(this).select2('data')[0].id;
        $.ajax({
            type: 'GET',
            url:  `${APP_URL}/admin/profile/states/${id}`
        }).then(function (data) {
            let options = '<option selected hidden>Select State</option>';
            for (i=0; i<data.length; i++) {
                const { name, id } =  data[i];
                options += `<option value="${id}" >${name}</option>`;
            }
            stateSelector.html(options)
        });
    });

    // On State Change
    stateSelector.on('change', function () {
        const  id = $(this).select2('data')[0].id;
        $.ajax({
            type: 'GET',
            url:  `${APP_URL}/admin/profile/cities/${id}`
        }).then(function (data) {
            let options = '<option selected hidden>Select City</option>';
            for (i=0; i<data.length; i++) {
                const { name, id } =  data[i];
                options += `<option value="${id}" >${name}</option>`;
            }
            citySelector.html(options)
        });
    });
});
