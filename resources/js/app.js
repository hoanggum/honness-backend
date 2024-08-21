require('./bootstrap');
// resources/js/app.js
$(document).ready(function() {
    $('#loginForm').on('submit', function(e) {
        e.preventDefault(); // Ngăn chặn việc gửi form mặc định

        var formData = $(this).serialize(); // Lấy dữ liệu form

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            success: function(response) {
                // Nếu đăng nhập thành công, chuyển hướng đến trang mong muốn
                window.location.href = "{{ route('home') }}"; // Thay đổi route 'home' nếu cần
            },
            error: function(xhr) {
                // Xử lý lỗi nếu đăng nhập không thành công
                var errors = xhr.responseJSON.errors;
                var errorHtml = '';
                for (var key in errors) {
                    if (errors.hasOwnProperty(key)) {
                        errorHtml += '<div class="alert alert-danger">';
                        errorHtml += '<ul>';
                        errors[key].forEach(function(error) {
                            errorHtml += '<li>' + error + '</li>';
                        });
                        errorHtml += '</ul>';
                        errorHtml += '</div>';
                    }
                }
                $('.card-body').prepend(errorHtml); // Hiển thị lỗi trên trang
            }
        });
    });
});
$(document).ready(function() {
    $('#registerForm').on('submit', function(e) {
        e.preventDefault(); // Ngăn gửi dữ liệu mặc định

        var formData = $(this).serialize(); // Lấy dữ liệu từ biểu mẫu

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            success: function(response) {
                // Xử lý phản hồi thành công (ví dụ: điều hướng, thông báo, v.v.)
                window.location.href = response.redirect; // Redirect sau khi thành công
            },
            error: function(xhr) {
                // Xử lý lỗi (hiển thị lỗi ở đây)
                var errors = xhr.responseJSON.errors;
                $('#error-messages').empty(); // Xóa thông báo lỗi cũ

                $.each(errors, function(key, value) {
                    $.each(value, function(index, error) {
                        var errorHtml = '<div class="alert alert-danger">' + error + '</div>';
                        $('#error-messages').append(errorHtml);
                    });
                });
            }
        });
    });
});
