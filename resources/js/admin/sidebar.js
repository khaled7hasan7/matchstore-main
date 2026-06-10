document.addEventListener('DOMContentLoaded', function() {
    // Sidebar toggle functionality (if toggle button exists)
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');
    const content = document.getElementById('content');

    if (sidebarToggle && sidebar && content) {
        sidebarToggle.addEventListener('click', function () {
            sidebar.classList.toggle('collapsed');
            content.classList.toggle('collapsed');
        });
    }

    // Language change functionality
    document.querySelectorAll('.language-select').forEach(item => {
        item.addEventListener('click', function (e) {
            e.preventDefault();
            const selectedLang = this.getAttribute('data-lang');
            const languageModal = document.getElementById('languageChangeModal');

            if (languageModal) {
                const modal = new bootstrap.Modal(languageModal);
                modal.show();

                const confirmButton = document.getElementById('confirmChange');
                if (confirmButton) {
                    confirmButton.onclick = function () {
                        modal.hide();

                        axios.post('/admin/change-language', {
                            _token: document.querySelector('meta[name="csrf-token"]').content,
                            lang: selectedLang
                        })
                        .then(response => {
                            console.log(response.data);
                            window.location.reload();
                        })
                        .catch(error => {
                            console.error(error);
                        });
                    };
                }
            }
        });
    });
});


