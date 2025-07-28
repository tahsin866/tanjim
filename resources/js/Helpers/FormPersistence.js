// Form Persistence Helper
export const FormPersistence = {
    // Clear all form related localStorage data
    clearAllFormData() {
        const keysToRemove = [];

        // Get all localStorage keys
        for (let i = 0; i < localStorage.length; i++) {
            const key = localStorage.key(i);

            // Remove keys related to form data
            if (key && (
                key.startsWith('basicinfo_') ||
                key.startsWith('education_') ||
                key.includes('form_data') ||
                key.includes('photo_info') ||
                key.includes('divisions') ||
                key.includes('districts') ||
                key.includes('thanas')
            )) {
                keysToRemove.push(key);
            }
        }

        // Remove the keys
        keysToRemove.forEach(key => {
            localStorage.removeItem(key);
        });

        console.log('Form data cleared from localStorage');
    },

    // Clear only specific form section data
    clearFormSection(section) {
        const keysToRemove = [];

        for (let i = 0; i < localStorage.length; i++) {
            const key = localStorage.key(i);

            if (key && key.startsWith(`${section}_`)) {
                keysToRemove.push(key);
            }
        }

        keysToRemove.forEach(key => {
            localStorage.removeItem(key);
        });

        console.log(`${section} form data cleared from localStorage`);
    },

    // Save success message
    saveSuccessMessage(message) {
        localStorage.setItem('form_success_message', message);
    },

    // Get and clear success message
    getAndClearSuccessMessage() {
        const message = localStorage.getItem('form_success_message');
        if (message) {
            localStorage.removeItem('form_success_message');
        }
        return message;
    },

    // Check if form has unsaved data
    hasUnsavedData() {
        for (let i = 0; i < localStorage.length; i++) {
            const key = localStorage.key(i);
            if (key && (
                key.includes('form_data') ||
                key.includes('photo_info')
            )) {
                return true;
            }
        }
        return false;
    },

    // Get form completion percentage
    getFormCompletionPercentage() {
        const basicInfoData = localStorage.getItem('basicinfo_form_data');
        const educationData = localStorage.getItem('education_form_data');

        let completedSections = 0;
        let totalSections = 2;

        if (basicInfoData) {
            const data = JSON.parse(basicInfoData);
            if (data.fullNameBangla && data.fullNameEnglish && data.phoneNumber) {
                completedSections++;
            }
        }

        if (educationData) {
            const data = JSON.parse(educationData);
            if (data.dept_takmil || data.dept_ifta || data.dept_hifz || data.dept_qirat) {
                completedSections++;
            }
        }

        return Math.round((completedSections / totalSections) * 100);
    }
};
