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
            if (value?.length > 8 && (/^(http|https):\/\/[^ "]+$/.test(value))) return true;
            return 'A valid website is required.';
        },
    ],
    accountPhone: [
        value => {
            // const phoneNumberRegex = /^\d{10}$/; // Regular expression to match 10-digit phone numbers
            const phoneNumberRegex = /^(\+|\d)\d+$/; // Regular expression to match 10-digit phone numbers
            if (phoneNumberRegex.test(value)) return true;
            // return 'Invalid phone number. Please enter a 10-digit number.';
            return 'Invalid phone number. Please enter a phone number.';
        },
    ]
}
export default validityState;