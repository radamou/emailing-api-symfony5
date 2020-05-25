import { makeStyles } from '@material-ui/core/styles';

export const formStyles = makeStyles(theme => ({
    root: {
        width: '98%',
        fontSize: theme.typography.caption,
        alignItems: 'center',
        justifyContent: 'center',
    },
    card: {
        marginTop: theme.spacing(3),
        width: '98%',
        alignItems: 'center',
        justifyContent: 'center'
    },
    header: {
        color: theme.palette.grey[800],
        backgroundColor: theme.palette.secondary.main,
        height: '1.2vh;'
    },
    field: {
        width: '78%',
        marginBottom:theme.spacing(3)
    },
    choice: {
        width: '50%'
    }
}));
