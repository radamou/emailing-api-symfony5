import { makeStyles } from '@material-ui/core/styles';

const loginStyles = makeStyles(theme => ({
    root: {
        height: '100vh',
        maxWidth: '200vh'
    },
    image: {
        backgroundImage: 'url(img/coursier1.jpg)',
        backgroundRepeat: 'no-repeat',
        backgroundSize: 'cover',
        backgroundPosition: 'center',
    },
    grid: {
        display: 'flex',
        flexDirection: 'center',
        alignItems: 'center',
        justifyContent: 'center'
    },
    paper: {
        margin: theme.spacing(8, 4),
        display: 'flex',
        flexDirection: 'column',
        alignItems: 'center',
    },
    avatar: {
        margin: theme.spacing(1),
        backgroundColor: theme.palette.secondary.main,
    },
    form: {
        width: '100%', // Fix IE 11 issue.
        marginTop: theme.spacing(1),
    },
    submit: {
        margin: theme.spacing(3, 0, 2),
    },
}));

export default loginStyles;