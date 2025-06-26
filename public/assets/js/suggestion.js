document.addEventListener('DOMContentLoaded', function() {
    document.querySelector('.suggestionDiv').addEventListener('click', function(e) {
        const deleteBtn = e.target.closest('.deleteBtn');
        if (!deleteBtn) return;
        
        const article = deleteBtn.closest('.suggestion');
        const idInput = article.querySelector('input[name="id"]');
        if (!idInput) return;

        const suggestionId = idInput.value;

        article.style.opacity = '0.5';
        deleteBtn.disabled = true;

        $.ajax({
            type: 'POST',
            url: 'admin.php',
            data: { 
                suggestionId: suggestionId 
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $(article).fadeOut(250, function() {
                        $(this).remove();
                    });
                } else {
                    article.style.opacity = '1';
                    deleteBtn.disabled = false;
                    alert(response.message);
                }
            },
            error: function(xhr, status, error) {
                article.style.opacity = '1';
                deleteBtn.disabled = false;
                alert("Error: " + error);
            }
        });
    });
});