<script type="module">    
    $(document).ready(function () {
        if (sessionStorage.getItem('theme')) {
            document.body.setAttribute('data-bs-theme', sessionStorage.getItem('theme'));
        } else {
            document.body.setAttribute('data-bs-theme', 'light');
        }

        function setTheme(theme) {
            sessionStorage.setItem('theme', theme);
            document.body.setAttribute('data-bs-theme', theme);
        }

        $('.hide-theme-dark').click(function (event) {
            event.preventDefault();
            setTheme('dark');
        });

        // Tambahkan event listener untuk tautan mode terang
        $('.hide-theme-light').click(function (event) {
            event.preventDefault();
            setTheme('light');
        });
    });
</script>