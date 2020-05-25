import { makeStyles } from "@material-ui/core/styles";

export const breadCrumbStyle = makeStyles(theme => ({
    root: {
        display: 'flex',
        alignItems: 'center',
        justifyContent: 'flex-start',
        backgroundColor:theme.palette.background.paper,
        borderRadius: '4px',
        padding: theme.spacing(0.5),
        marginLeft: theme.spacing(2),
        marginTop: theme.spacing(5),
        height: theme.spacing(5),
        border: '1px solid #ebeff6',
        borderColor: '#ebeff6',
        boxShadow: '0 1px 1px rgba(0,0,0,.05)',
        color: '#D95459',
        fontFamily: 'Muli-Regular'
    },
}));