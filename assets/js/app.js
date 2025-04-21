$(document).ready(function () {
    
    const pageURL="/phpfolder/crud_jquery";
    
    var currentPage = 1;
    var pageSize = 5;
    var totalPages = 0;

    function loadUsers(page = 1, limit = 10) {
        
        $.ajax({
            url: pageURL + '/controller/user-handler.php',
            type: 'GET',
            data: { action: 'read', page: page, limit: limit },
            success: function (response) {
                console.log('Successfully loaded users:', response);
                $('#userTable tbody').html(response);
                updatePaginationControls(page, totalPages);
                attachActionListeners();
                
            }
        });
    }
    
    
    

    function updatePaginationControls(currentPage, totalPages) {
        var paginationHtml = '';
        if (currentPage > 1) {
            paginationHtml += '<button class="pagination-btn" data-page="' + (currentPage - 1) + '">Previous</button>';
        }
        if (totalPages <= 5) {
            for (var i = 1; i <= totalPages; i++) {
                paginationHtml += '<button class="pagination-btn' + (i === currentPage ? ' active' : '') + '" data-page="' + i + '">' + i + '</button>';
            }
        } else {
            if (currentPage <= 3) {
                for (var i = 1; i <= 3; i++) {
                    paginationHtml += '<button class="pagination-btn' + (i === currentPage ? ' active' : '') + '" data-page="' + i + '">' + i + '</button>';
                }
                paginationHtml += '...';
                paginationHtml += '<button class="pagination-btn" data-page="' + totalPages + '">' + totalPages + '</button>';
            } else if (currentPage >= totalPages - 2) {
                paginationHtml += '<button class="pagination-btn" data-page="1">1</button>';
                paginationHtml += '...';
                for (var i = totalPages - 2; i <= totalPages; i++) {
                    paginationHtml += '<button class="pagination-btn' + (i === currentPage ? ' active' : '') + '" data-page="' + i + '">' + i + '</button>';
                }
            } else {
                paginationHtml += '<button class="pagination-btn" data-page="1">1</button>';
                paginationHtml += '...';
                for (var i = currentPage - 1; i <= currentPage + 1; i++) {
                    paginationHtml += '<button class="pagination-btn' + (i === currentPage ? ' active' : '') + '" data-page="' + i + '">' + i + '</button>';
                }
                paginationHtml += '...';
                paginationHtml += '<button class="pagination-btn" data-page="' + totalPages + '">' + totalPages + '</button>';
            }
        }
        if (currentPage < totalPages) {
            paginationHtml += '<button class="pagination-btn" data-page="' + (currentPage + 1) + '">Next</button>';
        }
        $('#pagination').html(paginationHtml);
    }

    
    function attachActionListeners() {
        // Edit button click event
        $('.edit-btn').click(function (e) {
            e.preventDefault();
            const id = $(this).data('id');
            const name = $(this).data('name');
            const email = $(this).data('email');
            const gender = $(this).data('gender');
            const photo = $(this).data('photo');
    
            // Pre-fill form fields with existing data for editing
            $('#name').val(name);
            $('#email').val(email);
            $('input[name="gender"][value="' + gender + '"]').prop('checked', true);
            $('#id').val(id); // Save ID for editing
            $('#action').val('update'); // Set action to update
            $('#btn').text('Update'); // Change button text to Update
            // Display the current photo
            if (photo) {
                $('#photo-preview').attr('src', photo).show();
            } else {
                $('#photo-preview').hide();
            }
        });
    
        // Delete button click event
        $('.delete-btn').click(function(e) {
            e.preventDefault();
            const id = $(this).data('id');
            $.ajax({
                url: pageURL + '/controller/user-handler.php',
                type: 'POST',
                data: { action: 'delete', id: id },
                success: function(response) {
                    var result = JSON.parse(response);
                    if (result.success) {
                        loadUsers(currentPage, pageSize);
                    } else {
                        alert(result.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error deleting user:', error);
                }
            });
        });
    
        // Pagination button click event
        $('.pagination-btn').click(function() {
            currentPage = $(this).data('page');
            loadUsers(currentPage, pageSize);
        });
    
        // Page size selector change event
        $('#pageSizeSelector').change(function() {
            pageSize = $(this).val();
            loadUsers(currentPage, pageSize); // Load users with the new page size without resetting the current page
        });
    }
    

    loadUsers(currentPage, pageSize);

    $('#userForm').on('submit', function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        for (var pair of formData.entries()) {
            console.log(pair[0] + ', ' + pair[1]); // Log each key-value pair
        }
        $.ajax({
            url: pageURL + '/controller/user-handler.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                var result = JSON.parse(response);
                if (result.success) {
                    loadUsers(currentPage, pageSize);
                    $('#userForm')[0].reset();
                    $('#btn').text('Submit'); // Reset button text to Submit
                    $('#photo-preview').hide(); // Hide photo preview
                } else {
                    alert(result.message);
                }
            },
            error: function (xhr, status, error) {
                console.error('Error creating/updating user:', error);
            }
        });
    });
});

function previewPhoto(event) {
    var input = event.target;
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#photo-preview').attr('src', e.target.result).show();
        };
        reader.readAsDataURL(input.files[0]);
    }
}
