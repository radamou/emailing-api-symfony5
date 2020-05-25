export const getUrl = () => {
    switch (process.env.REACT_APP_STAGE) {
        case 'dev':
            return {
                secureUrl: process.env.REACT_APP_SECURE_DEV,
                symplApp: process.env.REACT_APP_SYMPL_APP_API_DEV,
            };
        case 'test':
            return {
                secureUrl: process.env.REACT_APP_SECURE_TEST,
                symplApp: process.env.REACT_APP_SYMPL_APP_API_TEST,
            };
        case 'prod':
            return {
                secureUrl: process.env.REACT_APP_SECURE_PROD,
                symplApp: process.env.REACT_APP_SYMPL_APP_API_PROD,
            };
        default:
            return '';
    }
};

