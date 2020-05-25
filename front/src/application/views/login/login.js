import React, { useState } from 'react';
import Avatar from '@material-ui/core/Avatar';
import Button from '@material-ui/core/Button';
import CssBaseline from '@material-ui/core/CssBaseline';
import TextField from '@material-ui/core/TextField';
import Paper from '@material-ui/core/Paper';
import Grid from '@material-ui/core/Grid';
import Typography from '@material-ui/core/Typography';
import loginStyles from "../../../assets/views/loginStyle";
import { useLogin, useNotify } from 'react-admin';


export default function SignInSide() {
    const classes = loginStyles();
    const [username, setEmail] = useState('');
    const [password, setPassword] = useState('');
    const login = useLogin();
    const notify = useNotify();
    const submit = (e) => {
        e.preventDefault();
        login({ username, password })
            .catch(() => notify('Invalid email or password'));
    };

    return (
        <Grid container component="main" className={classes.root}>
            <CssBaseline />
            <Grid item xs={12} sm={8} md={5} component={Paper} elevation={6} square className={classes.grid}>
                <div className={classes.paper}>
                    <Avatar src="favicon.ico" />
                    <Typography component="h1" variant="h5">Connexion</Typography>
                    <form className={classes.form} onSubmit={submit}>
                        <TextField
                            variant="outlined"
                            margin="normal"
                            required
                            fullWidth
                            label="Adresse email"
                            name="username"
                            value={username}
                            onChange={e => setEmail(e.target.value)}
                            autoFocus
                        />

                        <TextField
                            variant="outlined"
                            margin="normal"
                            required
                            fullWidth
                            name="password"
                            label="Mode de passe"
                            type="password"
                            value={password}
                            onChange={e => setPassword(e.target.value)}
                        />
                        <Button
                            type="submit"
                            fullWidth
                            variant="contained"
                            color="primary"
                            className={classes.submit}
                        >
                            Sign In
                        </Button>
                    </form>
                </div>
            </Grid>
            <Grid item xs={false} sm={4} md={7} className={classes.image} />
        </Grid>
    );
}