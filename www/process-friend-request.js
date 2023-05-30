$(document).ready(function() {
    // Accept Friend Request
    $('.accept-request-button').click(function() {
        var senderUsername = $(this).data('sender');
        $.ajax({
            url: 'accept-request.php',
            method: 'POST',
            data: { senderUsername: senderUsername },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Request accepted successfully
                    alert(response.message);
                    // Reload Page
                    location.reload();
                } else {
                    // Failed to accept request
                    alert(response.message);
                }
            },
            error: function(xhr, status, error) {
                // Error occurred during the AJAX request
                console.error(error);
            }
        });
    });

    // Reject Friend Request
    $('.reject-request-button').click(function() {
        var senderUsername = $(this).data('sender');
        $.ajax({
            url: 'reject-request.php',
            method: 'POST',
            data: { senderUsername: senderUsername },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Request rejected successfully
                    alert(response.message);
                    // Reload Page
                    location.reload();
                } else {
                    // Failed to reject request
                    alert(response.message);
                }
            },
            error: function(xhr, status, error) {
                // Error occurred during the AJAX request
                console.error(error);
            }
        });
    });
});
