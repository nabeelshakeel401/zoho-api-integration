const validityState = {
    dealName: [value => {
        if (value?.length > 3) return true;
        return 'Deal name is required.';
    }],
    dealStage: [
        value => {
            if (value?.length > 3) return true;
            return 'Deal stage is required.';
        },
    ],
    accountName: [
        value => {
            if (value?.length > 3) return true;
            return 'Account name is required.';
        },
    ],
    accountWebsite: [
        value => {
            if (value?.length > 3) return true;
            return 'Account website is required.';
        },
    ],
    accountPhone: [
        value => {
            const phoneNumberRegex = /^\d{10}$/; // Regular expression to match 10-digit phone numbers
            if (phoneNumberRegex.test(value)) return true;
            return 'Invalid phone number. Please enter a 10-digit number.';
        },
    ]
}
export default validityState;