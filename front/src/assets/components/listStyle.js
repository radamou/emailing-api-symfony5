import { makeStyles } from '@material-ui/core/styles';

const listStyles = makeStyles(theme => ({
    container: {
        margin: '2em'
    },
    root: {
        height: '25vh',
        margin: '0.5em',
        verticalAlign: 'top',
        width: '20vw',
        display: 'inline-block',
        [theme.breakpoints.down('lg')]: {
            width: '24vw',
            display: 'inline-block',
        },
        [theme.breakpoints.down('sm')]: {
            width: '40vw'
        },
        [theme.breakpoints.down('xs')]: {
            display: 'block',
            height: '30vh',
            width: '80vw'
        }
    },
    content: {
        height: '10vh',
        overflow: 'hidden'
    },
    cartModifier: {
        height: '17vh',
    },
    actions: {
        textAlign:'left'
    }
}));

export default listStyles;


