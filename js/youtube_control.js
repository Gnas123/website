$(document).ready(function () {
    // Listen for the modal close event
    $(".modal").on("hidden.bs.modal", function () {
        // Find the iframe within the closed modal
        const iframe = $(this).find("iframe");
        // Reset the src attribute to stop the video
        iframe.attr("src", iframe.attr("src"));
    });
});