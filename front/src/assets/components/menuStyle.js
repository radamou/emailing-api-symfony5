import { makeStyles } from '@material-ui/core/styles';

const menuStyles = makeStyles(theme => ({
    root: {
        width: '100%',
        backgroundColor: theme.palette.background.paper,
    },
    nested: {
        paddingLeft: theme.spacing(4),
        color: "#999",
        fontWeight: 'bold',
        lineHeight: '1.7em',
        fontSize: '0.9em'
    },
    items: {
        justifyContent: 'space-between',
        color: "#999",
        fontWeight: 'bold',
        lineHeight: '1.7em',
        fontSize: '0.9em'
    },
    arrow: {
       marginRight: theme.spacing(0.01)
    },
    raLink: {
        paddingLeft: theme.spacing(1.5),
        color: "#999",
        fontWeight: 'bold',
        lineHeight: '1.7em',
        fontSize: '0.9em'
    }
}));

export default menuStyles;