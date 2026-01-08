// ===================================
// Timezone Capture for Contact Form
// ===================================

// Capture user's timezone automatically
document.addEventListener('DOMContentLoaded', function () {
    const timezoneField = document.getElementById('timezone');
    if (timezoneField) {
        try {
            const timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
            const offset = new Date().getTimezoneOffset();
            const offsetHours = Math.abs(offset / 60);
            const offsetSign = offset > 0 ? '-' : '+';
            timezoneField.value = `${timezone} (UTC${offsetSign}${offsetHours})`;
        } catch (e) {
            timezoneField.value = 'Unable to detect';
        }
    }
});
