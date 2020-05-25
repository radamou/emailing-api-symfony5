import React, {cloneElement } from 'react';
import PropTypes from 'prop-types';
import { useDispatch } from 'react-redux';
import classNames from 'classnames';
import MuiAppBar from '@material-ui/core/AppBar';
import Toolbar from '@material-ui/core/Toolbar';
import IconButton from '@material-ui/core/IconButton';
import Typography from '@material-ui/core/Typography';
import Avatar from '@material-ui/core/Avatar';
import useMediaQuery from '@material-ui/core/useMediaQuery';
import { toggleSidebar } from 'ra-core';

import LoadingIndicator from './loadingIndicator';
import DefaultUserMenu from './userMenu';
import HideOnScroll from './hideOnScroll';
import appBarStyles from "../../assets/views/appBarStyle";

const MyAppBar = ({
                    children,
                    classes: classesOverride,
                    className,
                    logo,
                    logout,
                    open,
                    title,
                    userMenu,
                    ...rest
                }) => {
    const classes = appBarStyles({ classes: classesOverride });
    const dispatch = useDispatch();
    const isXSmall = useMediaQuery(theme => theme.breakpoints.down('xs'));

    return (
        <HideOnScroll>
            <MuiAppBar className={className} color="secondary" {...rest}>
                <Toolbar
                    disableGutters
                    variant={isXSmall ? 'regular' : 'dense'}
                    className={classes.toolbar}
                >
                    <IconButton
                        color="inherit"
                        aria-label="open drawer"
                        onClick={() => dispatch(toggleSidebar())}
                        className={classNames(classes.menuButton)}
                    >
                        <Avatar style={{width:'30px', height:"30px"}} classes={{
                            root: open
                                ? classes.menuButtonIconOpen
                                : classes.menuButtonIconClosed,
                        }} src="favicon.ico"/>

                    </IconButton>
                    <Typography variant="h6" className={classes.title}>Sympl</Typography>
                    <LoadingIndicator />
                    {cloneElement(userMenu, { logout })}
                </Toolbar>
            </MuiAppBar>
        </HideOnScroll>
    );
};

MyAppBar.propTypes = {
    children: PropTypes.node,
    classes: PropTypes.object,
    className: PropTypes.string,
    logout: PropTypes.element,
    open: PropTypes.bool,
    userMenu: PropTypes.element,
};

MyAppBar.defaultProps = {
    userMenu: <DefaultUserMenu />,
};

export default MyAppBar;