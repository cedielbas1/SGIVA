// Simple client-side validation for SGIVA forms
document.addEventListener('DOMContentLoaded', function () {
    function showError(field, message) {
        const el = document.querySelector('.js-error[data-for="' + field.name + '"]');
        if (el) {
            el.textContent = message;
            el.style.display = 'block';
            field.classList.add('is-invalid');
        }
    }

    function clearError(field) {
        const el = document.querySelector('.js-error[data-for="' + field.name + '"]');
        if (el) {
            el.textContent = '';
            el.style.display = '';
            field.classList.remove('is-invalid');
        }
    }

    function validateField(field) {
        if (!field) return true;
        const value = (field.type === 'checkbox') ? (field.checked ? '1' : '') : field.value.trim();
        if (field.hasAttribute('required') && value === '') {
            showError(field, 'Este campo es obligatorio.');
            return false;
        }
        const max = field.getAttribute('maxlength');
        if (max && value.length > parseInt(max, 10)) {
            showError(field, `Máximo ${max} caracteres.`);
            return false;
        }
        clearError(field);
        return true;
    }

    // Attach input listeners
    document.querySelectorAll('.js-validate').forEach(function (field) {
        field.addEventListener('input', function () {
            validateField(field);
        });
        // validate on blur as well
        field.addEventListener('blur', function () {
            validateField(field);
        });
    });

    // Form submit handling
    document.querySelectorAll('.js-validate-form').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            let ok = true;
            form.querySelectorAll('.js-validate').forEach(function (field) {
                if (!validateField(field)) ok = false;
            });
            if (!ok) {
                e.preventDefault();
                // focus the first invalid field
                const firstInvalid = form.querySelector('.is-invalid');
                if (firstInvalid) firstInvalid.focus();
            }
        });
    });
});
