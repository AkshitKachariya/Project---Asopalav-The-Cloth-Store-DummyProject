</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('sidebar');
        const navLinks = document.querySelectorAll('aside nav a');
        const dropdowns = document.querySelectorAll('.dropdown');

        // Toggle sidebar
        sidebarToggle.addEventListener('click', (event) => {
            event.stopPropagation();
            sidebar.classList.toggle('open-sidebar');
            document.body.classList.toggle('sidebar-open-overlay');

            // Toggle hamburger and close icon
            const icon = document.getElementById('toggleIcon');
            icon.classList.toggle('fa-bars');
            icon.classList.toggle('fa-xmark');
            icon.classList.toggle('rotate-90');
        });


        // Close sidebar on outside click (mobile only)
        document.addEventListener('click', (event) => {
            if (window.innerWidth < 1024) {
                if (!sidebar.contains(event.target) && !sidebarToggle.contains(event.target) && sidebar.classList.contains('open-sidebar')) {
                    sidebar.classList.remove('open-sidebar');
                    document.body.classList.remove('sidebar-open-overlay');
                }
            }
        });

        // Close sidebar when any nav link is clicked (mobile only)
        navLinks.forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth < 1024) {
                    sidebar.classList.remove('open-sidebar');
                    document.body.classList.remove('sidebar-open-overlay');
                }
            });
        });

        // Dropdown toggle
        dropdowns.forEach(dropdown => {
            const button = dropdown.querySelector('button');
            const content = dropdown.querySelector('.dropdown-content');
            const arrow = dropdown.querySelector('svg');

            button.addEventListener('click', () => {
                dropdowns.forEach(other => {
                    if (other !== dropdown) {
                        other.querySelector('.dropdown-content').classList.remove('open');
                        other.querySelector('svg').classList.remove('rotate-180');
                    }
                });

                content.classList.toggle('open');
                arrow.classList.toggle('rotate-180');
            });
        });

        // Admin name initial for profile
        const adminNameSpan = document.querySelector('#adminProfile span');
        if (adminNameSpan) {
            const name = adminNameSpan.textContent.trim();
            if (name) {
                document.getElementById('profilePhoto').textContent = name.charAt(0).toUpperCase();
            }
        }

        // Highlight active nav link and open related dropdown
        const currentPath = window.location.pathname.split('/').pop();
        navLinks.forEach(link => {
            const href = link.getAttribute('href');
            if (href === currentPath) {
                link.classList.add('active-link');
                const parentDropdown = link.closest('.dropdown');
                if (parentDropdown) {
                    parentDropdown.querySelector('.dropdown-content').classList.add('open');
                    parentDropdown.querySelector('svg').classList.add('rotate-180');
                }
            }
        });

        // On resize: reset overlay and mobile view
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024) {
                sidebar.classList.remove('open-sidebar');
                document.body.classList.remove('sidebar-open-overlay');

                // Ensure hamburger icon resets
                const icon = document.getElementById('toggleIcon');
                icon.classList.add('fa-bars');
                icon.classList.remove('fa-xmark');
            }
        });
    });
</script>
</body>

</html>