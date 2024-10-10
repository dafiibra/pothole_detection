<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Add event listeners to log links
        const logLinks = document.querySelectorAll('.log-link');
        logLinks.forEach(function(link) {
            link.addEventListener('click', function(event) {
                const activityName = link.getAttribute('data-activity');
                logActivity(activityName);
            });
        });

        function logActivity(activityName) {
            axios.post('{{ route('log.activity') }}', {
                activity_name: activityName
            })
            .then(response => {
                console.log('Activity logged successfully');
            })
            .catch(error => {
                console.error('Error logging activity:', error);
            });
        }
    });
</script>
