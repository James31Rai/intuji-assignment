document.getElementById("disconnectForm").addEventListener("submit", function(event) {
    if (!confirm("Are you sure you want to disconnect?")) {
        event.preventDefault();
    }
});