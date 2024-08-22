document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('a.ajax-link').forEach(function(link) {
        link.addEventListener('click', function(event) {
            event.preventDefault();
            let url = this.href;
            fetch(url)
                .then(response => response.text())
                .then(html => {
                    document.querySelector('main').innerHTML = html;
                })
                .catch(error => console.error('Error:', error));
        });
    });
});
