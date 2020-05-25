import { createMuiTheme } from '@material-ui/core/styles';

const theme = createMuiTheme({
    sidebar: {
        width: 240, // The default value is 240
        closedWidth: 45, // The default value is 55
    },
    palette: {
        primary: {
            main: '#337ab7',
        },
        secondary: {
            main: '#d9edf7',
        }
    },
    typography: {
        fontFamily: [
            'Muli-Regular',
            'Arial',
            'sans-serif',
        ].join(','),
    }
});

export default theme;