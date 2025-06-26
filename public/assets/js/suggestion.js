document.addEventListener('DOMContentLoaded', function() {
    document.querySelector('.suggestionDiv').addEventListener('click', async function(e) {
        const deleteBtn = e.target.closest('.deleteBtn');
        if (!deleteBtn) return;
        
        const suggestion = deleteBtn.closest('.suggestion');
        const idInput = suggestion?.querySelector('input[name="id"]');
        const suggestionInput = suggestion?.querySelector('input[name="suggestionName"]');
        if (!idInput) return;
        if (!suggestionInput) return;

        var myJSON =  {
            suggestionId: idInput.value,
            suggestion: suggestionInput.value,
        };

        suggestion.style.opacity = '0.5';
        deleteBtn.disabled = true;

        try {
            const response = await fetch(window.location.href, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({myJSON}),
            });

            const contentType = response.headers.get('content-type');
            if (!contentType || !contentType.includes('application/json')) {
                throw new Error('Invalid response from server');
            }

            const data = await response.json();
            
            if (!response.ok || !data.success) {
                throw new Error(data.message || 'Deletion failed');
            }

            suggestion.style.transition = 'opacity 0.1s';
            suggestion.style.opacity = '0';
            setTimeout(() => {
                suggestion.remove();
                if (data.redirect) {
                    if (data.message) {
                        alert(data.message);
                    }
                    window.location.href = data.redirect;
                } else if (data.message) {
                    alert(data.message);
                }
            }, 100);
            
        } catch (error) {
            suggestion.style.opacity = '1';
            deleteBtn.disabled = false;
            
            console.error('Error:', error);
            alert(`Operation failed: ${error.message}`);
        }
    });
});