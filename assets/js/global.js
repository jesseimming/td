function runPHP(url, args) {
    $.ajax({
        type: 'POST',
        url: url,
        data: args,
        success: function(response) {
            return response;
        },
        error: function(xhr, status, error) {
            console.error(error);
        }
    });
}