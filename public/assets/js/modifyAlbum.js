document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('fileInput').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                document.querySelector('.uploadImg').src = event.target.result;
            }
            reader.readAsDataURL(file);
        }
    });
});